<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد مدیر</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #ffffff;
            padding-top: 15px;
        }
        .sidebar a {
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky">
                <h4 class="text-center">مدیر</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">داشبورد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">مدیریت کاربران</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">مدیریت محصولات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php">تغییر رمز عبور</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="pt-3 pb-2 mb-3">
                <h2>داشبورد مدیر</h2>
                <p>به داشبورد مدیر خوش آمدید!</p>
            </div>
        </main>
    </div>
</div>
</body>
</html>
