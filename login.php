<?php
session_start();
require 'db.php';


$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'seller':
                header("Location: seller_dashboard.php");
                break;
            case 'customer':
                header("Location: customer_dashboard.php");
                break;
        }
        // فرض کنید پس از تایید کاربر، ایمیل او از دیتابیس دریافت شده است
$_SESSION['email'] = $user['email'];

        exit();
    } else {
        $message = "ایمیل یا رمز عبور اشتباه است.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فرم ورود</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="login-form text-right">
        <h2 class="text-center">ورود</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?= $message ?></div>
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
            <button type="submit" class="btn btn-primary btn-block">ورود</button>
        </form>
        <p class="text-center mt-3">حساب کاربری ندارید؟ <a href="register.php">ثبت‌نام</a></p>
    </div>
</div>
</body>
</html>
