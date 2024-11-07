<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>داشبورد مدیر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: #d1d1d1;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
        }
        .sidebar .navbar-brand {
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar بالا -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">داشبورد مدیر</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- سایدبار -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-sticky">
                <div class="text-center mt-3">
                    <!-- نمایش ایمیل مدیر -->
                    <h5>خوش آمدید، <?php echo htmlspecialchars($_SESSION['email']); ?></h5>
                </div>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">داشبورد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">مدیریت کاربران</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php">تغییر رمز عبور</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list_customers.php">لیست مشتری ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list_sellers.php">لیست فروشنده ها</a>
                    </li>
                    
                    <!-- دکمه خروج -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> خروج
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- محتوای اصلی -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2 class="mt-4">داشبورد مدیر</h2>
            <p>محتوای داشبورد...</p>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
