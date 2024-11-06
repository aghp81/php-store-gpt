<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // اعتبارسنجی ایمیل
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "آدرس ایمیل معتبر نیست.";
    } else {
        // بررسی تکراری بودن ایمیل
        $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->rowCount() > 0) {
            $message = "این ایمیل قبلاً ثبت شده است.";
        } else {
            // ثبت‌نام کاربر جدید
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            if ($stmt->execute([$email, $password, $role])) {
                $message = "ثبت‌نام با موفقیت انجام شد.";
            } else {
                $message = "خطا در ثبت‌نام.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فرم ثبت‌نام</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="register-form">
        <h2 class="text-center">ثبت‌نام</h2>
        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="ایمیل" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="رمز عبور" required>
            </div>
            <div class="form-group">
                <label for="role">نقش کاربری</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="admin">مدیر</option>
                    <option value="seller">فروشنده</option>
                    <option value="customer">مشتری</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">ثبت‌نام</button>
        </form>
        <p class="text-center mt-3">قبلاً ثبت‌نام کرده‌اید؟ <a href="login.php">ورود</a></p>
    </div>
</div>
</body>
</html>
