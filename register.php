<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // بررسی تکراری بودن نام کاربری
    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->rowCount() > 0) {
        $message = "این نام کاربری قبلاً ثبت شده است. لطفاً نام کاربری دیگری انتخاب کنید.";
    } else {
        // ثبت نام کاربر جدید
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $password, $role])) {
            $message = "ثبت‌نام با موفقیت انجام شد.";
        } else {
            $message = "خطا در ثبت‌نام.";
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
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Vazir', sans-serif;
        }
        .register-form {
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
    <div class="register-form">
        <h2 class="text-center">ثبت‌نام</h2>
        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?= $message ?></div>
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
