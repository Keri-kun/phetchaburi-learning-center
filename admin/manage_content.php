<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = ['title' => '', 'category' => '', 'content' => '', 'video' => '', 'image' => ''];
$title_action = "เพิ่มเนื้อหาใหม่";

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();
    $title_action = "แก้ไขเนื้อหา";

    // Fetch existing extra images
    $imgStmt = $pdo->prepare("SELECT * FROM post_images WHERE post_id = ?");
    $imgStmt->execute([$id]);
    $extra_images = $imgStmt->fetchAll();
} else {
    $extra_images = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $title_en = $_POST['title_en'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $content_en = $_POST['content_en'];
    $video = $_POST['video'];
    $image = $post['image'];

    // Image Upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $filename;
        }
    }

    $excerpt = mb_substr(strip_tags($content), 0, 150) . '...';
    $excerpt_en = mb_substr(strip_tags($content_en), 0, 150) . '...';

    if ($id) {
        // Update
        $sql = "UPDATE posts SET title=?, title_en=?, category=?, content=?, content_en=?, excerpt=?, excerpt_en=?, image=?, video=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $title_en, $category, $content, $content_en, $excerpt, $excerpt_en, $image, $video, $id]);
        $current_post_id = $id;
    } else {
        // Insert
        $sql = "INSERT INTO posts (title, title_en, category, content, content_en, excerpt, excerpt_en, image, video) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $title_en, $category, $content, $content_en, $excerpt, $excerpt_en, $image, $video]);
        $current_post_id = $pdo->lastInsertId();
    }

    // Process Multiple Extra Images Upload
    if (isset($_FILES['extra_images']['name']) && is_array($_FILES['extra_images']['name'])) {
        $target_dir = "../uploads/";
        $countfiles = count($_FILES['extra_images']['name']);
        
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['extra_images']['name'][$i];
            
            // Skip empty inputs
            if(empty($filename)) continue;

            $new_filename = time() . "_" . $i . "_" . basename($filename);
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES['extra_images']['tmp_name'][$i], $target_file)) {
                $ins_img = $pdo->prepare("INSERT INTO post_images (post_id, image_filename) VALUES (?, ?)");
                $ins_img->execute([$current_post_id, $new_filename]);
            }
        }
    }

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title_action; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Sarabun', sans-serif; background: #f3eef9; padding: 20px; }
        form { background: #fff; padding: 30px; max-width: 800px; margin: 20px auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(139,107,177,0.15); border: 1px solid #e8daf5; }
        h1 { margin-top: 0; color: #5c3d8f; border-bottom: 2px solid #e8daf5; padding-bottom: 15px; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #6a4ea0; margin-bottom: 5px; }
        input[type="text"], textarea, select { width: 100%; padding: 12px; border: 1.5px solid #d4b8f0; border-radius: 8px; transition: border 0.3s; font-family: inherit; background: #faf8fd; color: #4a4060; }
        input[type="text"]:focus, textarea:focus, select:focus { border-color: #8B6BB1; outline: none; background: #fff; }
        textarea { height: 150px; resize: vertical; }
        button { margin-top: 30px; padding: 12px 25px; background: linear-gradient(135deg, #8B6BB1, #a07fcc); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; width: 100%; transition: all 0.3s; font-family: inherit; font-weight: 600; }
        button:hover { background: linear-gradient(135deg, #7a5ba0, #8B6BB1); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139,107,177,0.3); }
        .back-link { display: inline-block; margin-bottom: 10px; text-decoration: none; color: #8B6BB1; font-weight: 500; transition: 0.3s; }
        .back-link:hover { color: #5c3d8f; transform: translateX(-5px); }
        .image-gallery { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .img-item { position: relative; width: 120px; height: 120px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd; }
        .img-item img { width: 100%; height: 100%; object-fit: cover; }
        .img-delete { position: absolute; top: 5px; right: 5px; background: rgba(220, 53, 69, 0.9); color: white; border: none; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 14px; font-weight: bold; cursor: pointer; }
        .img-delete:hover { background: red; }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-link">&larr; กลับหน้า Dashboard</a>
    <form method="post" enctype="multipart/form-data">
        <h1><?php echo $title_action; ?></h1>
        
        <label>หัวข้อ (TH)</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

        <label>Title (EN)</label>
        <input type="text" name="title_en" value="<?php echo htmlspecialchars(isset($post['title_en']) ? $post['title_en'] : ''); ?>" placeholder="English Title">

        <label>หมวดหมู่ (Category)</label>
        <select name="category" required>
            <option value="history" <?php if($post['category'] == 'history') echo 'selected'; ?>>ประวัติความเป็นมา</option>
            <option value="identity" <?php if($post['category'] == 'identity') echo 'selected'; ?>>อัตลักษณ์</option>
            <option value="map" <?php if($post['category'] == 'map') echo 'selected'; ?>>แผนที่</option>
            <option value="learning" <?php if($post['category'] == 'learning') echo 'selected'; ?>>แหล่งเรียนรู้</option>
            <option value="attraction" <?php if($post['category'] == 'attraction') echo 'selected'; ?>>แหล่งท่องเที่ยว</option>
        </select>

        <label>เนื้อหา (TH)</label>
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>

        <label>Content (EN)</label>
        <textarea name="content_en" placeholder="English Content..."><?php echo htmlspecialchars(isset($post['content_en']) ? $post['content_en'] : ''); ?></textarea>

        <label>ภาพหน้าปก (Cover Image) <?php if($post['image']) echo "<br><small>ปัจจุบัน: {$post['image']}</small>"; ?></label>
        <input type="file" name="image">

        <hr style="border: 1px solid #eee; margin: 30px 0;">

        <label>รูปภาพเพิ่มเติมในเนื้อหา สไลเดอร์ (Extra Images for Slider)</label>
        <small style="color: #666; display:block; margin-bottom:10px;">คุณสามารถเลือกไฟล์ได้หลายไฟล์พร้อมกันเพื่อทำสไลเดอร์รูปภาพในหน้ารายละเอียด</small>
        <input type="file" name="extra_images[]" multiple accept="image/*">

        <?php if (!empty($extra_images)): ?>
            <div style="margin-top: 15px;">
                <strong>รูปภาพที่อัปโหลดไว้แล้ว:</strong>
                <div class="image-gallery">
                    <?php foreach($extra_images as $imgRow): ?>
                        <div class="img-item">
                            <img src="../uploads/<?php echo htmlspecialchars($imgRow['image_filename']); ?>" alt="Extra Image">
                            <a href="delete_image.php?id=<?php echo $imgRow['id']; ?>&post_id=<?php echo $id; ?>" class="img-delete" onclick="return confirm('ยืนยันลบรูปนี้?')">&times;</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <hr style="border: 1px solid #eee; margin: 30px 0;">

        <label>ลิงก์วิดีโอ (Video URL)</label>
        <input type="text" name="video" value="<?php echo htmlspecialchars($post['video']); ?>">

        <button type="submit">บันทึกข้อมูล</button>
    </form>
</body>
</html>
