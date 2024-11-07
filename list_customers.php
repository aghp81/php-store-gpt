<?php
// شروع جلسه و بررسی ورود به سیستم
session_start();

// بررسی اینکه آیا کاربر مدیر است یا خیر
if ($_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
}

// اتصال به پایگاه داده
require_once 'db.php';

// تعریف متغیر برای جستجو
$searchTerm = '';

// بررسی ارسال فرم جستجو
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// دستور SQL برای بازیابی لیست مشتری‌ها با جستجو
$sql = "SELECT id, name, family_name, email, created_at FROM users WHERE role = 'customer'";

// اگر جستجویی وجود داشته باشد، شرط LIKE برای جستجو در ایمیل یا نام مشتری‌ها اضافه می‌شود
if (!empty($searchTerm)) {
    $sql .= " AND (name LIKE :searchTerm OR family_name LIKE :searchTerm OR email LIKE :searchTerm)";
}

$stmt = $pdo->prepare($sql);

// اگر جستجو فعال باشد، پارامتر را به کوئری اضافه می‌کنیم
if (!empty($searchTerm)) {
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
}

$stmt->execute();

// بازیابی نتایج
$customers = $stmt->fetchAll();

// پیغام در صورت عدم وجود مشتری
if (empty($customers)) {
    $message = "هیچ مشتری‌ای یافت نشد.";
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لیست مشتری‌ها</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>لیست مشتری‌ها</h2>
    
    <!-- فرم جستجو -->
    <form method="get" action="" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="جستجو کنید..." />
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">جستجو</button>
            </div>
        </div>
    </form>

    <!-- جدول نمایش مشتری‌ها -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>ایمیل</th>
                <th>تاریخ ثبت</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($customers)) {
                foreach ($customers as $customer) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($customer['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['family_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['created_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>" . (isset($message) ? $message : "هیچ مشتری‌ای یافت نشد.") . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
