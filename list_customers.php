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

// اضافه کردن فایل jdf.php فقط یک‌بار
require_once 'jdf.php';

// متغیر جستجو
$searchKeyword = '';
if (isset($_POST['search'])) {
    $searchKeyword = $_POST['search'];
}

// بازیابی لیست مشتری‌ها از دیتابیس با امکان جستجو
$sql = "SELECT id, name, family_name, email, created_at FROM users WHERE role = 'customer' AND (name LIKE :keyword OR family_name LIKE :keyword OR email LIKE :keyword)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['keyword' => '%' . $searchKeyword . '%']);
$customers = $stmt->fetchAll();
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
    <form method="post" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="جستجو بر اساس نام، نام خانوادگی یا ایمیل" value="<?php echo htmlspecialchars($searchKeyword); ?>">
        <button type="submit" class="btn btn-primary">جستجو</button>
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
                    // تبدیل تاریخ میلادی به شمسی
                    $created_at = $customer['created_at'];
                    $jalali_date = jdate('Y/m/d', strtotime($created_at));
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($customer['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['family_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($customer['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($jalali_date) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>هیچ مشتری‌ای یافت نشد.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
