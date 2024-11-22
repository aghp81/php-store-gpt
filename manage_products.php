<?php
session_start();
include 'db.php';

// بررسی اینکه آیا user_role تنظیم شده است یا خیر
if (!isset($_SESSION['role'])) {
    // اگر تنظیم نشده است، کاربر را به صفحه لاگین هدایت کنید
    header("Location: login.php");
    exit;
}

// بررسی نقش کاربر برای فیلتر کردن محصولات
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // 'admin' یا 'seller'

// نمایش همه محصولات برای مدیر و محصولات خود فروشنده برای فروشنده
if ($user_role === 'admin') {
    $sql = "SELECT products.*, users.name AS created_by_name FROM products LEFT JOIN users ON products.created_by = users.id";
} else {
    $sql = "SELECT products.*, users.name AS created_by_name FROM products LEFT JOIN users ON products.created_by = users.id WHERE created_by = ?";
}

// دریافت اطلاعات محصولات به همراه نام و نام خانوادگی ایجادکننده محصول
if ($_SESSION['role'] === 'admin') {
    // برای مدیر، همه محصولات را نمایش می‌دهد
    $query = "SELECT products.*, users.name, users.family_name 
              FROM products 
              JOIN users ON products.created_by = users.id";
} else {
    // برای فروشنده، فقط محصولات خودش را نمایش می‌دهد
    $query = "SELECT products.id AS product_id,
    products.name AS product_name,
    products.main_image,
    products.price,
    users.name AS creator_name,
    users.family_name AS creator_family_name
              FROM products 
              JOIN users ON products.created_by = users.id 
              WHERE created_by = :user_id";
}

// آماده‌سازی کوئری
$stmt = $pdo->prepare($query);
if ($_SESSION['role'] === 'seller') {
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت محصولات</title>
</head>
<body>
    <h2>لیست محصولات</h2>
    <table border="1">
        <tr>
            <th>نام محصول</th>
            <th>توضیحات</th>
            <th>دسته‌بندی</th>
            <th>تعداد موجودی</th>
            <th>وضعیت موجودی</th>
            <th>ایجاد شده توسط</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['product_name']); ?></td>
                <td><?= htmlspecialchars($product['description']); ?></td>
                <td><?= htmlspecialchars($product['category_id']); ?></td>
                <td><?= htmlspecialchars($product['stock_quantity']); ?></td>
                <td><?= $product['is_available'] ? 'موجود' : 'ناموجود'; ?></td>
                <td><?= htmlspecialchars($product['name'] . ' ' . $product['family_name']) ?></td>
                <td><a href="edit_product.php?id=<?= $product['id']; ?>">ویرایش</a></td>
                <td><a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
