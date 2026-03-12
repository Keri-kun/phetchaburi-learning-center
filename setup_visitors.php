<?php
require_once 'db.php';

try {
    // Create visitors table
    $sql = "CREATE TABLE IF NOT EXISTS `visitors` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `ip_address` varchar(45) NOT NULL,
      `visit_date` date NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `ip_date` (`ip_address`, `visit_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Successfully created 'visitors' table.<br>";
} catch (PDOException $e) {
    echo "Error updating schema: " . $e->getMessage();
}
?>
