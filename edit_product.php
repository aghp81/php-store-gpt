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

$product_id = $_GET['id'];

// دریافت اطلاعات محصول
$query = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// اگر محصول پیدا نشد، بازگشت به صفحه مدیریت محصولات
if (!$product) {
    header("Location: manage_products.php");
    exit();
}

// دریافت دسته‌بندی‌ها
$category_stmt = $pdo->query("SELECT * FROM  categories");
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

// دریافت تگ‌ها
$tags_stmt = $pdo->query("SELECT * FROM tags");
$tags = $tags_stmt->fetchAll(PDO::FETCH_ASSOC);

// بررسی ارسال فرم و بروزرسانی اطلاعات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $stock_quantity = $_POST['stock_quantity'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;
    $selected_tags = $_POST['tags'] ?? [];

    // بروزرسانی اطلاعات محصول
    $update_query = "UPDATE products SET name = :name, description = :description, category_id = :category_id, stock_quantity = :stock_quantity, is_available = :is_available WHERE id = :id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->bindParam(':name', $name);
    $update_stmt->bindParam(':description', $description);
    $update_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $update_stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
    $update_stmt->bindParam(':is_available', $is_available, PDO::PARAM_INT);
    $update_stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $update_stmt->execute();

    // بروزرسانی تگ‌ها
    $pdo->prepare("DELETE FROM product_tags WHERE product_id = :product_id")->execute([':product_id' => $product_id]);
    foreach ($selected_tags as $tag_id) {
        $pdo->prepare("INSERT INTO product_tags (product_id, tag_id) VALUES (:product_id, :tag_id)")
            ->execute([':product_id' => $product_id, ':tag_id' => $tag_id]);
    }

    // هدایت به صفحه مدیریت محصولات
    header("Location: manage_products.php");
    exit();
}
?>

?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش محصول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>ویرایش محصول</h2>
    <form action="edit_product.php?id=<?= $product_id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">نام محصول</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">دسته‌بندی</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">تعداد موجودی</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" <?= $product['is_available'] ? 'checked' : '' ?>>
            <label for="is_available" class="form-check-label">موجود است</label>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">تگ‌ها</label>
            <select class="form-select" id="tags" name="tags[]" multiple>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], array_column($tags, 'id')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tag['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
    </form>
</div>
</body>
</html>