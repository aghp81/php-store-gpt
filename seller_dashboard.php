<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد فروشنده</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar bg-dark">
            <div class="position-sticky">
                <h4 class="text-center text-light">فروشنده</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">داشبورد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">محصولات من</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">سفارشات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="change_password.php">تغییر رمز عبور</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="pt-3 pb-2 mb-3">
                <h2>داشبورد فروشنده</h2>
                <p>به داشبورد فروشنده خوش آمدید!</p>
            </div>
        </main>
    </div>
</div>
</body>
</html>
