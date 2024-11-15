<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$product_id = $_GET['id'];

// بررسی دسترسی به محصول
if ($user_role === 'admin') {
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
} else {
    $sql = "DELETE FROM products WHERE id = ? AND created_by = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id, $user_id]);
}

header("Location: manage_products.php");
?>
