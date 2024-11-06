<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
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
        exit();
    } else {
        $message = "نام کاربری یا رمز عبور اشتباه است.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فرم ورود</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Vazir', sans-serif;
        }
        .login-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-control::placeholder {
            color: #bbb;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-form">
        <h2 class="text-center">ورود</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="نام کاربری" required>
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
