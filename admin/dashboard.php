<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();

// Get visitors info
$today = date('Y-m-d');
$total_stmt = $pdo->query("SELECT COUNT(*) FROM visitors");
$total_visitors = $total_stmt->fetchColumn();

// Using prepared statement for security just in case
$today_stmt = $pdo->prepare("SELECT COUNT(*) FROM visitors WHERE visit_date = ?");
$today_stmt->execute([$today]);
$today_visitors = $today_stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Sarabun', sans-serif; background: #f3eef9; margin: 0; display: flex; }
        .sidebar { width: 250px; background: linear-gradient(180deg, #4a2d78, #6a4ea0); color: #f0e8ff; height: 100vh; position: fixed; padding: 20px; display: flex; flex-direction: column; }
        .sidebar h2 { margin-top: 0; margin-bottom: 2rem; font-size: 1.5rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 1rem; color: #e8d5ff; }
        .sidebar a { display: block; color: #d4b8f0; text-decoration: none; padding: 12px 15px; border-radius: 8px; transition: 0.3s; margin-bottom: 5px; }
        .sidebar a:hover { background: rgba(255,255,255,0.15); color: #fff; }
        .main-content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
        h1 { color: #5c3d8f; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 4px 12px rgba(139,107,177,0.12); border-radius: 12px; overflow: hidden; border: 1px solid #e8daf5; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f0e8fb; }
        th { background: linear-gradient(135deg, #8B6BB1, #9d7ec4); color: #fff; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px; }
        tr:hover { background-color: #faf5ff; }
        .btn { padding: 8px 12px; text-decoration: none; color: #fff; border-radius: 6px; font-size: 0.85rem; display: inline-block; transition: 0.2s; }
        .btn-add { background: linear-gradient(135deg, #7cb87e, #5da660); padding: 10px 20px; font-size: 1rem; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .btn-add:hover { background: linear-gradient(135deg, #5da660, #4a9050); transform: translateY(-2px); }
        .btn-edit { background: linear-gradient(135deg, #f0a840, #e09020); margin-right: 5px; }
        .btn-edit:hover { background: linear-gradient(135deg, #e09020, #c87010); }
        .btn-delete { background: linear-gradient(135deg, #e06878, #c8505e); }
        .btn-delete:hover { background: linear-gradient(135deg, #c8505e, #a03040); }
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(139,107,177,0.12); flex: 1; border-left: 5px solid #9B72CF; display: flex; flex-direction: column; justify-content: center; }
        .stat-card h3 { margin: 0; color: #7A6A99; font-size: 1rem; font-weight: 500;}
        .stat-card .value { font-size: 2rem; font-weight: 700; color: #5c3d8f; margin-top: 10px; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="../index.php" target="_blank">View Site</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h1>ภาพรวมและการจัดการเนื้อหา</h1>
        
        <!-- Visitor Stats -->
        <div class="stats-container">
            <div class="stat-card" style="border-left-color: #5da660;">
                <h3><i class="fas fa-users"></i> ผู้เข้าชมวันนี้</h3>
                <div class="value"><?php echo number_format($today_visitors); ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #9B72CF;">
                <h3><i class="fas fa-chart-line"></i> ผู้เข้าชมทั้งหมด</h3>
                <div class="value"><?php echo number_format($total_visitors); ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #f0a840;">
                <h3><i class="fas fa-file-alt"></i> จำนวนเนื้อหา (โพสต์)</h3>
                <div class="value"><?php echo number_format(count($posts)); ?></div>
            </div>
        </div>

        <a href="manage_content.php" class="btn btn-add">+ เพิ่มเนื้อหาใหม่</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>หัวข้อ (Title)</th>
                    <th>หมวดหมู่ (Category)</th>
                    <th>วันที่ (Date)</th>
                    <th>จัดการ (Action)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['category']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></td>
                    <td>
                        <a href="manage_content.php?id=<?php echo $post['id']; ?>" class="btn btn-edit">แก้ไข</a>
                        <a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-delete" onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
