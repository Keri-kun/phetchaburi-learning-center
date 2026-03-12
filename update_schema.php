<?php
require_once '../db.php';

try {
    // Check if 'district' column exists
    $check = $pdo->query("SHOW COLUMNS FROM posts LIKE 'district'");
    if ($check->rowCount() == 0) {
        // Add columns
        $sql = "ALTER TABLE posts 
                ADD COLUMN district VARCHAR(100) DEFAULT NULL AFTER category,
                ADD COLUMN district_en VARCHAR(100) DEFAULT NULL AFTER district";
        $pdo->exec($sql);
        echo "Successfully added 'district' and 'district_en' columns.<br>";
    } else {
        echo "Columns already exist.<br>";
    }
} catch (PDOException $e) {
    echo "Error updating schema: " . $e->getMessage();
}
?>
