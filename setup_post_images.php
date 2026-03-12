<?php
require_once 'db.php';

try {
    // Create post_images table
    $sql = "CREATE TABLE IF NOT EXISTS `post_images` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `post_id` int(11) NOT NULL,
      `image_filename` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `post_id` (`post_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Successfully created 'post_images' table.<br>";
} catch (PDOException $e) {
    echo "Error updating schema: " . $e->getMessage();
}
?>
