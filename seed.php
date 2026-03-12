<?php
require_once 'db.php';

// 1. Reset Tables (Optional, be careful)
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("TRUNCATE TABLE posts");

// 2. Create Admin User
$password = password_hash("password", PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES ('admin', ?)");
$stmt->execute([$password]);
echo "Admin user created (User: admin, Pass: password)<br>";

// 3. Insert Sample Data
$contents = [
    [
        'category' => 'history',
        'title' => 'ประวัติความเป็นมาจังหวัดเพชรบุรี',
        'content' => 'เพชรบุรี เป็นจังหวัดหนึ่งในภาคกลางตอนล่าง (บางหน่วยงานจัดให้อยู่ในภาคตะวันตก) มีภูมิประเทศทั้งเป็นที่สูงติดเทือกเขาและที่ราบชายฝั่งทะเล มักเรียกชื่อสั้นๆ ว่า "เมืองเพชร"
        <br><br>
        ในอดีตเพชรบุรีเป็นเมืองเก่าแก่ที่มีความสำคัญทางประวัติศาสตร์ โดยมีหลักฐานการอยู่อาศัยของมนุษย์มาตั้งแต่สมัยก่อนประวัติศาสตร์ ต่อมาได้รับอิทธิพลจากวัฒนธรรมทวารวดีและขอม...
        ',
        'image' => '' // User can upload later
    ],
    [
        'category' => 'identity',
        'title' => 'อัตลักษณ์เมืองเพชร',
        'content' => 'เมืองเพชรบุรีมีชื่อเสียงในด้าน "เมือง 3 รส" ได้แก่ รสเค็มจากเกลือสมุทร รสหวานจากน้ำตาลโตนด และรสเปรี้ยวจากมะนาวท่ายาง นอกจากนี้ยังมีงานสกุลช่างเมืองเพชรที่โดดเด่น เช่น งานปูนปั้น งานแทงหยวก และงานทอง...',
        'image' => ''
    ],
    [
        'category' => 'learning',
        'title' => 'ศูนย์แสดงและสาธิตงานสกุลช่างเมืองเพชร',
        'content' => 'สถานที่รวบรวมและจัดแสดงผลงานศิลปะชั้นครูของจังหวัดเพชรบุรี ทั้งงานปูนปั้น งานแกะสลัก และงานจิตรกรรม...',
        'image' => ''
    ],
    [
        'category' => 'learning',
        'title' => 'ครูช่างเมืองเพชร',
        'content' => 'แนะนำครูช่างผู้สืบสานภูมิปัญญาศิลปะเมืองเพชร...',
        'image' => ''
    ],
    [
        'category' => 'learning',
        'title' => 'ย่านแสดงวิถีชีวิตคนเมืองเพชร',
        'content' => 'ชุมชนย่านเมืองเก่าริมแม่น้ำเพชรบุรี ที่ยังคงวิถีชีวิตดั้งเดิม...',
        'image' => ''
    ]
];

$stmt = $pdo->prepare("INSERT INTO posts (category, title, content, excerpt, image) VALUES (?, ?, ?, ?, ?)");

foreach ($contents as $c) {
    $excerpt = mb_substr(strip_tags($c['content']), 0, 150) . '...';
    $stmt->execute([$c['category'], $c['title'], $c['content'], $excerpt, $c['image']]);
}

echo "Sample contents inserted.<br>";
echo "<a href='index.php'>Go to Homepage</a>";
?>
