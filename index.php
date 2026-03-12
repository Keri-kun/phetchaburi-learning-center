<?php 
require_once 'db.php'; 
require_once 'counter.php'; // Track visitors
require_once 'lang.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text[$lang]['province_title']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- Header -->
    <header>
        <nav class="navbar">
            <a href="index.php" class="logo"><i class="fas fa-landmark"></i> Phetchaburi <img src="images/ministry_logo.png" class="inline-logo" alt="Ministry Logo" style="height: 40px; width: auto;"></a>
            
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>

            <ul class="nav-links">
                <li><a href="index.php"><?php echo $text[$lang]['home']; ?></a></li>
                <li><a href="attractions.php"><?php echo $lang=='th' ? 'แหล่งท่องเที่ยว' : 'Attractions'; ?></a></li>
                <li><a href="#history"><?php echo $text[$lang]['history']; ?></a></li>
                <li><a href="#learning"><?php echo $text[$lang]['learning']; ?></a></li>
                <li><a href="#contact"><?php echo $text[$lang]['contact']; ?></a></li>
                <!-- Language Switcher -->
                <li class="lang-switch">
                    <a href="?lang=th" class="<?php echo $lang == 'th' ? 'active' : ''; ?>">TH</a> | 
                    <a href="?lang=en" class="<?php echo $lang == 'en' ? 'active' : ''; ?>">EN</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Hero / Banner -->
    <section class="hero">
        <div class="hero-content">
            <h1><?php echo $text[$lang]['province_title']; ?></h1>
            <p><?php echo $text[$lang]['province_subtitle']; ?></p>
        </div>
    </section>

    <!-- Main Layout: Sidebar vs Content -->
    <div class="container">
        
        <!-- Sidebar (Left) -->
        <aside class="sidebar">
            <h3><i class="fas fa-book-open"></i> <?php echo $text[$lang]['learning']; ?></h3>
            <ul>
                <!-- Dynamic List from DB -->
                <?php
                $stmt = $pdo->query("SELECT * FROM posts WHERE category = 'learning' LIMIT 10");
                while($row = $stmt->fetch()) {
                    $title = get_content($row, 'title');
                    echo "<li><a href='detail.php?id={$row['id']}'>• {$title}</a></li>";
                }
                ?>
            </ul>

            <h3 style="margin-top: 2rem;"><i class="fas fa-video"></i> <?php echo $text[$lang]['video_recommend']; ?></h3>
             <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/hhWtUfUn0Bk?si=inIamqYnyZUxDkvU" frameborder="0" allowfullscreen></iframe>
            </div>
        </aside>

        <!-- Main Content (Right) -->
        <main class="main-content">
            
            <!-- Quick Menu Buttons -->
            <div class="menu-buttons">
                <a href="#history" class="menu-btn"><i class="fas fa-history"></i> <?php echo $text[$lang]['history']; ?></a>
                <a href="attractions.php" class="menu-btn"><i class="fas fa-map-signs"></i> <?php echo $lang=='th' ? 'แหล่งท่องเที่ยว' : 'Attractions'; ?></a>
                <a href="#identity" class="menu-btn"><i class="fas fa-fingerprint"></i> <?php echo $text[$lang]['identity']; ?></a>
                <a href="#map" class="menu-btn"><i class="fas fa-map-marked-alt"></i> <?php echo $text[$lang]['map']; ?></a>
            </div>

            <!-- Content Area 1: Video / Highlight -->
            <section class="highlight-section" id="video-highlight">
                <h2 style="margin-bottom:1rem; color:var(--primary);"><?php echo $text[$lang]['video_title']; ?></h2>
                <div class="video-wrapper" style="padding-bottom: 50%;"> 
                     <iframe src="https://www.youtube.com/embed/hhWtUfUn0Bk?si=inIamqYnyZUxDkvU" frameborder="0" allowfullscreen></iframe>
                </div>
            </section>

            <!-- Learning Grid (Below) -->
            <section id="learning-grid">
                <h2 class="highlight-section" style="padding:1rem; margin-bottom:1rem; text-align:center;"><?php echo $text[$lang]['activities']; ?></h2>
                <div class="grid-container">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM posts WHERE category = 'learning' LIMIT 4");
                    $stmt->execute();
                    $posts = $stmt->fetchAll();
                    $posts = $stmt->fetchAll();
                    foreach ($posts as $post) {
                        if (strpos($post['image'], 'http') === 0) {
                            $img = $post['image'];
                        } else {
                            $img = $post['image'] ? "uploads/{$post['image']}" : "https://via.placeholder.com/300x200?text=No+Image";
                        }
                        
                        $title = get_content($post, 'title');
                        echo "
                        <div class='card'>
                            <img src='{$img}' alt='{$title}'>
                            <div class='card-body'>
                                <h4 class='card-title'>{$title}</h4>
                                <a href='detail.php?id={$post['id']}'>{$text[$lang]['read_more']}</a>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
            </section>

            <!-- Info Sections -->
            <section id="history" class="highlight-section">
                <h2><?php echo $text[$lang]['history']; ?></h2>
                <?php
                $hist = $pdo->query("SELECT * FROM posts WHERE category='history' LIMIT 1")->fetch();
                if($hist) {
                    $excerpt = get_content($hist, 'excerpt');
                    echo "<p>{$excerpt}</p><br><a href='detail.php?id={$hist['id']}'>{$text[$lang]['read_more']}...</a>";
                }
                ?>
            </section>

             <section id="identity" class="highlight-section">
                <h2><?php echo $text[$lang]['identity']; ?></h2>
                <?php
                $iden = $pdo->query("SELECT * FROM posts WHERE category='identity' LIMIT 1")->fetch();
                if($iden) {
                    $excerpt = get_content($iden, 'excerpt');
                    echo "<p>{$excerpt}</p><br><a href='detail.php?id={$iden['id']}'>{$text[$lang]['read_more']}...</a>";
                }
                ?>
            </section>

            <!-- Creators Section -->
            <section id="creators" class="highlight-section" style="text-align: center;">
                <h2><?php echo isset($text[$lang]['creators']) ? $text[$lang]['creators'] : 'ผู้จัดทำ'; ?></h2>
                <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-top: 20px;">
                    <!-- Creator 1 -->
                    <div class="creator-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 250px;">
                        <h4 style="color: var(--primary); margin-bottom: 5px;">ชื่อ นายวิทย์สุพกิจ บุญวานิช</h4>
                        <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">ตำแหน่ง / หน้าที่ Full Stack Developer</p>
                        <p style="font-size: 0.85em; color: #888;">รหัสนักศึกษา: 654274115</p>
                    </div>

                    <!-- Creator 2 -->
                    <div class="creator-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 250px;">
                        <h4 style="color: var(--primary); margin-bottom: 5px;">ชื่อ นางสาว รัษฎาภรณ์ เกตุแก้ว</h4>
                        <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">ตำแหน่ง / หน้าที่ tester / Web Admin</p>
                        <p style="font-size: 0.85em; color: #888;">รหัสนักศึกษา: 654274105</p>
                    </div>
                </div>
                <p style="margin-top: 2rem; font-size: 0.9em; color: #555;">
                    สาขาวิชา คอมพิวเตอร์ประยุกต์ แขนงเว็บและมัลติมีเดีย มหาวิทยาลัยราชภัฎเพชรบุรี
                </p>
            </section>

            <section id="map" class="highlight-section">
                <h2><?php echo $text[$lang]['map']; ?></h2>
                <div class="map-responsive">
                    <iframe src="https://www.google.com/maps/d/embed?mid=1SCckEIK3taFx2zAPjZ4daEgEHyqy6KTz&ehbc=2E312F" width="100%" height="480" style="border:0;"></iframe>
                </div>
            </section>

        </main>
    </div>

    <!-- Contact Footer -->
    <footer id="contact">
        <h3><?php echo $text[$lang]['contact_us']; ?></h3>
        <p><?php echo $text[$lang]['learning_center']; ?></p>
        <div style="margin-top:1rem; display:flex; justify-content:center; gap:20px;">
            <a href="#" style="color:#F3EBFF; transition:all 0.3s ease;" aria-label="Facebook">
                <i class="fab fa-facebook fa-2x"></i>
            </a>
            <a href="#" style="color:#F3EBFF; transition:all 0.3s ease;" aria-label="Instagram">
                <i class="fab fa-instagram fa-2x"></i>
            </a>
            <a href="#" style="color:#F3EBFF; transition:all 0.3s ease;" aria-label="TikTok">
                <i class="fab fa-tiktok fa-2x"></i>
            </a>
        </div>
    </footer>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>
