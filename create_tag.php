<?php
session_start();
require_once 'db.php';

// Check if the user is logged in and has access (only admin and seller)
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'seller')) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tagName = $_POST['tag_name'];
    $createdBy = $_SESSION['user_id'];

    // Insert the new tag into the database
    $stmt = $pdo->prepare("INSERT INTO tags (name, created_by, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$tagName, $createdBy]);

    // Redirect to manage_tags.php after successful creation
    header('Location: manage_tags.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد تگ جدید</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>ایجاد تگ جدید</h2>
    <form action="create_tag.php" method="POST">
        <div class="mb-3">
            <label for="tag_name" class="form-label">نام تگ</label>
            <input type="text" class="form-control" id="tag_name" name="tag_name" required>
        </div>
        <button type="submit" class="btn btn-primary">ایجاد تگ</button>
    </form>
</div>
</body>
</html>
