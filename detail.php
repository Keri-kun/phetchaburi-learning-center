<?php
require_once 'db.php';
require_once 'lang.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch();

if (!$post) {
    die("Content not found.");
}

// Fetch extra images
$imgStmt = $pdo->prepare("SELECT * FROM post_images WHERE post_id = ?");
$imgStmt->execute([$id]);
$extra_images = $imgStmt->fetchAll();

$title = get_content($post, 'title');
$content = get_content($post, 'content');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - <?php echo $text[$lang]['province_title']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php" class="logo">
                <i class="fas fa-landmark"></i> Phetchaburi
                <img src="images/ministry_logo.png" class="inline-logo" alt="Ministry Logo" style="height: 40px; width: auto;">
            </a>

            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>

            <ul class="nav-links">
                <li><a href="index.php"><?php echo $text[$lang]['home']; ?></a></li>
                <li><a href="attractions.php"><?php echo $lang=='th' ? 'แหล่งท่องเที่ยว' : 'Attractions'; ?></a></li>
                <li><a href="index.php#history"><?php echo $lang=='th' ? 'ประวัติ' : 'History'; ?></a></li>
                <li><a href="index.php#contact"><?php echo $lang=='th' ? 'ติดต่อ' : 'Contact'; ?></a></li>
                <li class="lang-switch">
                    <a href="?lang=th&id=<?php echo $id; ?>" class="<?php echo $lang == 'th' ? 'active' : ''; ?>">TH</a> | 
                    <a href="?lang=en&id=<?php echo $id; ?>" class="<?php echo $lang == 'en' ? 'active' : ''; ?>">EN</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="section">
        <div style="max-width: 800px; margin: 3rem auto; background: #fff; padding: 2.5rem; border-radius: 14px; box-shadow: 0 6px 24px rgba(139,107,200,0.16); border: 1px solid #DDD0F5;">
            <h1 style="color: var(--primary); margin-bottom: 1rem; font-size: 2rem;"><?php echo htmlspecialchars($title); ?></h1>
            <p style="color: var(--text-soft); font-size: 0.9rem; background: var(--primary-pale); display:inline-block; padding: 4px 14px; border-radius: 50px;">Category: <?php echo htmlspecialchars($post['category']); ?> | Date: <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></p>
            
            <?php 
            $hasCover = !empty($post['image']);
            $hasExtra = !empty($extra_images);
            
            if ($hasCover || $hasExtra): 
                // Determine cover image source if exists
                if ($hasCover) {
                    $imgSrc = (strpos($post['image'], 'http') === 0) ? $post['image'] : "uploads/{$post['image']}";
                }
            ?>
                <!-- Detail Slider -->
                <style>
                    .detail-slides { position: relative; width: 100%; height: 500px; display: block; }
                    .detail-slide { position: absolute; top:0; left:0; width:100%; height:100%; opacity: 0; transition: opacity 0.6s ease-in-out; z-index: 1; pointer-events: none; }
                    .detail-slide.active { opacity: 1; z-index: 2; pointer-events: auto; }
                    .detail-slide img { width: 100%; height: 100%; object-fit: contain; background: #000; }
                </style>
                <div class="detail-slider-container" style="position:relative; width:100%; height:500px; overflow:hidden; border-radius:8px; margin: 1.5rem 0; background:#000;">
                    <div class="detail-slides">
                        <?php 
                        $slide_idx = 0;
                        if ($hasCover): 
                        ?>
                        <div class="detail-slide active">
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($title); ?>" style="width: 100%; height: 500px; object-fit:contain; display:block;">
                        </div>
                        <?php 
                        $slide_idx++;
                        endif; 
                        
                        foreach($extra_images as $extraImg):
                        ?>
                        <div class="detail-slide <?php echo ($slide_idx === 0) ? 'active' : ''; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($extraImg['image_filename']); ?>" alt="Extra Image" style="width: 100%; height: 500px; object-fit:contain; display:block;">
                        </div>
                        <?php 
                        $slide_idx++;
                        endforeach; 
                        ?>
                    </div>
                    
                    <?php if ($slide_idx > 1): ?>
                    <button class="detail-slider-btn detail-prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="detail-slider-btn detail-next-btn"><i class="fas fa-chevron-right"></i></button>
                    
                    <div class="detail-slider-dots">
                        <?php for($i=0; $i < $slide_idx; $i++): ?>
                        <span class="dot <?php echo ($i === 0) ? 'active' : ''; ?>" onclick="currentDetailSlide(<?php echo $i; ?>)"></span>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content" style="font-size: 1.1rem; line-height: 1.8;">
                <?php echo nl2br($content); ?>
            </div>

            <?php if ($post['video']): ?>
                <div style="margin-top: 2rem;">
                    <h3><?php echo $text[$lang]['video_recommend']; ?></h3>
                    <a href="<?php echo htmlspecialchars($post['video']); ?>" target="_blank">Watch Video</a>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 2.5rem; text-align: center;">
                <a href="index.php" style="background: linear-gradient(135deg, #9B72CF, #C3A8E8); color: #fff; padding: 12px 28px; text-decoration: none; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 14px rgba(155,114,207,0.35); display: inline-block; transition: all 0.3s ease;">← กลับหน้าหลัก</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Phetchaburi Learning Media</p>
    </footer>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }

        // Detail Slider Script
        const slides = document.querySelectorAll('.detail-slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.querySelector('.detail-prev-btn');
        const nextBtn = document.querySelector('.detail-next-btn');
        let currentSlide = 0;
        let slideInterval;

        function showDetailSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            if (index >= slides.length) { currentSlide = 0; }
            else if (index < 0) { currentSlide = slides.length - 1; }
            else { currentSlide = index; }
            
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function currentDetailSlide(index) {
            showDetailSlide(index);
            if (slides.length > 1) resetAutoSlide();
        }

        function resetAutoSlide() {
            if (slideInterval) clearInterval(slideInterval);
            slideInterval = setInterval(() => {
                showDetailSlide(currentSlide + 1);
            }, 3000);
        }

        if(slides.length > 1) {
            nextBtn.addEventListener('click', () => { showDetailSlide(currentSlide + 1); resetAutoSlide(); });
            prevBtn.addEventListener('click', () => { showDetailSlide(currentSlide - 1); resetAutoSlide(); });
            resetAutoSlide(); // start autoplay automatically
        }
    </script>
</body>
</html>
