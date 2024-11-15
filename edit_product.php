<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // 'admin' یا 'seller'
$product_id = $_GET['id'];

// بررسی دسترسی به محصول
if ($user_role === 'admin') {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
} else {
    $sql = "SELECT * FROM products WHERE id = ? AND created_by = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id, $user_id]);
}

$product = $stmt->fetch();
if (!$product) {
    die("شما دسترسی به این محصول ندارید.");
}

// پردازش فرم ویرایش
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'];
    $is_available = $_POST['is_available'];

    $update_sql = "UPDATE products SET name = ?, description = ?, stock_quantity = ?, is_available = ? WHERE id = ?";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$name, $description, $stock_quantity, $is_available, $product_id]);

    echo "محصول با موفقیت ویرایش شد!";
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش محصول</title>
</head>
<body>
    <h2>ویرایش محصول</h2>
    <form method="POST" action="">
        نام محصول: <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required><br>
        توضیحات: <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea><br>
        تعداد موجودی: <input type="number" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']); ?>" required><br>
        وضعیت موجودی:
        <select name="is_available" required>
            <option value="1" <?= $product['is_available'] ? 'selected' : ''; ?>>موجود</option>
            <option value="0" <?= !$product['is_available'] ? 'selected' : ''; ?>>ناموجود</option>
        </select><br><br>
        <button type="submit" name="submit">ذخیره تغییرات</button>
    </form>
</body>
</html>
