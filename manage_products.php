<?php
session_start();
include 'db.php';

// بررسی نقش کاربر برای فیلتر کردن محصولات
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role']; // 'admin' یا 'seller'

// نمایش همه محصولات برای مدیر و محصولات خود فروشنده برای فروشنده
if ($user_role === 'admin') {
    $sql = "SELECT products.*, users.name AS created_by_name FROM products LEFT JOIN users ON products.created_by = users.id";
} else {
    $sql = "SELECT products.*, users.name AS created_by_name FROM products LEFT JOIN users ON products.created_by = users.id WHERE created_by = ?";
}

$stmt = $pdo->prepare($sql);
if ($user_role !== 'admin') {
    $stmt->execute([$user_id]);
} else {
    $stmt->execute();
}

$products = $stmt->fetchAll();
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
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td><?= htmlspecialchars($product['description']); ?></td>
                <td><?= htmlspecialchars($product['category_id']); ?></td>
                <td><?= htmlspecialchars($product['stock_quantity']); ?></td>
                <td><?= $product['is_available'] ? 'موجود' : 'ناموجود'; ?></td>
                <td><?= htmlspecialchars($product['created_by_name']); ?></td>
                <td><a href="edit_product.php?id=<?= $product['id']; ?>">ویرایش</a></td>
                <td><a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
