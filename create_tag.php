<?php
session_start();
include 'db.php'; // فایل اتصال به دیتابیس
include 'check_role.php'; // چک نقش کاربر

// بررسی نقش کاربر
if (!in_array($_SESSION['role'], ['admin', 'seller'])) {
    echo "شما دسترسی لازم برای این بخش را ندارید.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $created_by = $_SESSION['user_id'];

    if (!empty($name)) {
        // درج تگ در دیتابیس
        $stmt = $pdo->prepare("INSERT INTO tags (name, created_by) VALUES (?, ?)");
        $stmt->execute([$name, $created_by]);
        echo "تگ با موفقیت ایجاد شد!";
    } else {
        echo "لطفا نام تگ را وارد کنید.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد تگ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>ایجاد تگ جدید</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">نام تگ</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">ایجاد تگ</button>
    </form>
</div>
</body>
</html>
