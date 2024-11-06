<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // هدایت به پنل مخصوص نقش
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
        echo "نام کاربری یا رمز عبور اشتباه است.";
    }
}
?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="نام کاربری" required>
    <input type="password" name="password" placeholder="رمز عبور" required>
    <button type="submit">ورود</button>
</form>
