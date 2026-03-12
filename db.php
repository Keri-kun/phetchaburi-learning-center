<?php
// Detect environment
$host_name = $_SERVER['HTTP_HOST'] ?? 'localhost';
if ($host_name == 'localhost' || $host_name == '127.0.0.1') {
    // Local / XAMPP
    $host = 'localhost';
    $dbname = 'phetchaburi_db';
    $username = 'root';
    $password = '';
} else {
    // Production / InfinityFree
    $host = 'sql300.infinityfree.com';
    $dbname = 'if0_41110034_phetchaburi_db';
    $username = 'if0_41110034';
    $password = 't24gMEbROJwwH6C';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
