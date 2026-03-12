<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบผู้ดูแลระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; background: linear-gradient(135deg, #e8daf5, #f5eeff); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 2.5rem; border-radius: 16px; box-shadow: 0 8px 32px rgba(139,107,177,0.18); width: 320px; border: 1px solid #e8daf5; }
        h2 { text-align: center; color: #6a4ea0; font-size: 1.5rem; margin-bottom: 1.2rem; }
        input { width: 100%; padding: 10px 14px; margin: 8px 0; border: 1.5px solid #d4b8f0; border-radius: 8px; box-sizing: border-box; font-family: 'Sarabun', sans-serif; background: #faf8fd; color: #4a4060; transition: border-color 0.3s; }
        input:focus { border-color: #8B6BB1; outline: none; background: #fff; }
        button { width: 100%; padding: 12px; background: linear-gradient(135deg, #8B6BB1, #a07fcc); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-family: 'Sarabun', sans-serif; font-weight: 600; margin-top: 10px; transition: all 0.3s; }
        button:hover { background: linear-gradient(135deg, #7a5ba0, #8B6BB1); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139,107,177,0.3); }
        .error { color: #c0628f; font-size: 0.9rem; text-align: center; background: #fde8f2; padding: 8px; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
