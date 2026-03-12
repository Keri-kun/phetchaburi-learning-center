<?php
session_start();
require_once 'db.php';

// Language Logic
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Translations
$text = [
    'th' => [
        'title_text' => 'แหล่งท่องเที่ยวจังหวัดเพชรบุรี',
        'title_html' => 'แหล่งท่องเที่ยวจังหวัดเพชรบุรี <img src="images/ministry_logo.png" class="inline-logo" alt="logo" style="height: 40px; width: auto;">',
        'home' => 'หน้าแรก',
        'all_districts' => 'ทุกอำเภอ',
        'read_more' => 'อ่านเพิ่มเติม',
        'districts' => [
            'Mueang' => 'อำเภอเมืองเพชรบุรี',
            'Cha-am' => 'อำเภอชะอำ',
            'Tha Yang' => 'อำเภอท่ายาง',
            'Ban Lat' => 'อำเภอบ้านลาด',
            'Ban Laem' => 'อำเภอบ้านแหลม',
            'Khao Yoi' => 'อำเภอเขาย้อย',
            'Nong Ya Plong' => 'อำเภอหนองหญ้าปล้อง',
            'Kaeng Krachan' => 'อำเภอแก่งกระจาน'
        ]
    ],
    'en' => [
        'title_text' => 'Phetchaburi Tourist Attractions',
        'title_html' => 'Phetchaburi <img src="images/ministry_logo.png" class="inline-logo" alt="logo" style="height: 40px; width: auto;"> Tourist Attractions',
        'home' => 'Home',
        'all_districts' => 'All Districts',
        'read_more' => 'Read More',
        'districts' => [
            'Mueang' => 'Mueang District',
            'Cha-am' => 'Cha-am District',
            'Tha Yang' => 'Tha Yang District',
            'Ban Lat' => 'Ban Lat District',
            'Ban Laem' => 'Ban Laem District',
            'Khao Yoi' => 'Khao Yoi District',
            'Nong Ya Plong' => 'Nong Ya Plong District',
            'Kaeng Krachan' => 'Kaeng Krachan District'
        ]
    ]
];

$selected_district = isset($_GET['district']) ? $_GET['district'] : 'all';

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text[$lang]['title_text']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .filter-bar {
            background: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .filter-btn {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background: #eee;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-family: 'Sarabun', sans-serif;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }
        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(135deg, #8B6BB1, #a07fcc);
            color: #fff;
        }
        .attraction-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .inline-logo {
            height: 40px;
            vertical-align: middle;
            margin: 0 5px;
        }
        @media (max-width: 480px) {
            .filter-bar { padding: 10px; }
            .filter-btn { padding: 8px 15px; margin: 2px; }
            .attraction-grid { padding: 10px; gap: 15px; }
            .header h1 { font-size: 1.2rem; }
            .inline-logo { height: 30px; }
        }
        .attraction-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .attraction-card:hover {
            transform: translateY(-5px);
        }
        .attraction-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .attraction-body {
            padding: 20px;
        }
        .attraction-district {
            display: inline-block;
            background: #f0e4ff;
            color: #7a4db5;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Header -->
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
                <li><a href="attractions.php" class="active"><?php echo $lang=='th' ? 'แหล่งท่องเที่ยว' : 'Attractions'; ?></a></li>
                <li><a href="index.php#history"><?php echo $lang=='th' ? 'ประวัติ' : 'History'; ?></a></li>
                <li><a href="index.php#contact"><?php echo $lang=='th' ? 'ติดต่อ' : 'Contact'; ?></a></li>
                <!-- Language Switcher -->
                <li class="lang-switch">
                    <a href="?lang=th&district=<?php echo $selected_district; ?>" class="<?php echo $lang=='th'?'active':''; ?>">TH</a> |
                    <a href="?lang=en&district=<?php echo $selected_district; ?>" class="<?php echo $lang=='en'?'active':''; ?>">EN</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <a href="?lang=<?php echo $lang; ?>&district=all" class="filter-btn <?php echo $selected_district == 'all' ? 'active' : ''; ?>">
            <?php echo $text[$lang]['all_districts']; ?>
        </a>
        <?php foreach ($text[$lang]['districts'] as $key => $name): ?>
            <a href="?lang=<?php echo $lang; ?>&district=<?php echo $key; ?>" class="filter-btn <?php echo $selected_district == $key ? 'active' : ''; ?>">
                <?php echo $name; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Content Grid -->
    <div class="attraction-grid">
        <?php
        $sql = "SELECT * FROM posts WHERE category = 'attraction'";
        $params = [];
        
        if ($selected_district != 'all') {
            $sql .= " AND district = ?";
            $params[] = $selected_district;
        }
        
        $sql .= " ORDER BY district ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $posts = $stmt->fetchAll();

        if (count($posts) > 0) {
            foreach ($posts as $post) {
                // Multi-language content
                $title = ($lang == 'en' && !empty($post['title_en'])) ? $post['title_en'] : $post['title'];
                $content = ($lang == 'en' && !empty($post['content_en'])) ? $post['content_en'] : $post['content'];
                $district_name = ($lang == 'en' && !empty($post['district_en'])) ? $post['district_en'] : $post['district'];
                
                // Excerpt
                $excerpt = mb_substr(strip_tags($content), 0, 100) . '...';
                
                // Image
                if (strpos($post['image'], 'http') === 0) {
                    $img = $post['image'];
                } else {
                    $img = $post['image'] ? "uploads/{$post['image']}" : "https://via.placeholder.com/300x200?text=No+Image";
                }

                echo "
                <div class='attraction-card'>
                    <img src='{$img}' class='attraction-img' alt='{$title}'>
                    <div class='attraction-body'>
                        <span class='attraction-district'><i class='fas fa-map-marker-alt'></i> {$district_name}</span>
                        <h3>{$title}</h3>
                        <p>{$excerpt}</p>
                        <a href='detail.php?id={$post['id']}' style='display:inline-block; margin-top:10px; color:#8B6BB1; font-weight:bold; text-decoration:none;'>
                            {$text[$lang]['read_more']} &rarr;
                        </a>
                    </div>
                </div>";
            }
        } else {
            echo "<p style='text-align:center; width:100%; color:#888;'>ไม่พบข้อมูล / No attractions found.</p>";
        }
        ?>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <h3><?php echo $lang=='th' ? 'ติดต่อเรา' : 'Contact Us'; ?></h3>
        <p><?php echo $lang=='th' ? 'ศูนย์การเรียนรู้จังหวัดเพชรบุรี' : 'Phetchaburi Learning Center'; ?></p>
    </footer>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }
    </script>
</body>
</html>
