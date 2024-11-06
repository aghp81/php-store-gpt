<?php
session_start();
require 'db.php';
$message = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // بازیابی رمز عبور فعلی کاربر از دیتابیس
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // بررسی رمز عبور فعلی
    if ($user && password_verify($currentPassword, $user['password'])) {
        // بررسی تطابق رمز عبور جدید و تایید آن
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // بروزرسانی رمز عبور در دیتابیس
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            if ($updateStmt->execute([$hashedPassword, $_SESSION['user_id']])) {
                $message = "رمز عبور با موفقیت تغییر یافت.";
            } else {
                $message = "خطا در تغییر رمز عبور.";
            }
        } else {
            $message = "رمز عبور جدید و تایید آن مطابقت ندارند.";
        }
    } else {
        $message = "رمز عبور فعلی نادرست است.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تغییر رمز عبور</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-center mt-5">تغییر رمز عبور</h2>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST" action="" class="mt-4">
        <div class="form-group">
            <label for="current_password">رمز عبور فعلی</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">رمز عبور جدید</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">تایید رمز عبور جدید</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">تغییر رمز عبور</button>
    </form>
</div>
</body>
</html>
