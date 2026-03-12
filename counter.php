<?php
require_once 'db.php';

try {
    // Determine the user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    // In some setups, you might want to check HTTP_X_FORWARDED_FOR as well
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    
    $today = date('Y-m-d');
    
    // Hash IP address with a secret salt for privacy (so if database is leaked, hackers can't see the real IPs)
    // Using md5 because it produces a 32 character string, which fits nicely in the varchar(45) column
    $hashed_ip = md5($ip_address . 'phetchaburi_secret_salt_2026');

    // Insert if not exists for today, using the hashed IP instead of plain IP
    $stmt = $pdo->prepare("INSERT IGNORE INTO visitors (ip_address, visit_date) VALUES (?, ?)");
    $stmt->execute([$hashed_ip, $today]);
    
} catch (PDOException $e) {
    // Silently fail on counter error to not break the page
}
?>
