<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$image_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

if ($image_id && $post_id) {
    // Get filename to delete from disk
    $stmt = $pdo->prepare("SELECT image_filename FROM post_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $img = $stmt->fetchColumn();

    if ($img) {
        $file_path = "../uploads/" . $img;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Delete from DB
        $del = $pdo->prepare("DELETE FROM post_images WHERE id = ?");
        $del->execute([$image_id]);
    }
}

header("Location: manage_content.php?id=" . $post_id);
exit;
