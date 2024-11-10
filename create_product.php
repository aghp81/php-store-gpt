<?php
session_start();
include 'db.php';

// بررسی نقش کاربر
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'seller') {
    echo "دسترسی غیرمجاز!";
    exit;
}

// دریافت دسته‌ها و تگ‌ها از دیتابیس
$categories = $pdo->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$tags = $pdo->query("SELECT id, name FROM tags")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد محصول جدید</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body dir="rtl">
<div class="container mt-5">
    <h2>ایجاد محصول جدید</h2>
    <form action="store_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>نام محصول</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>

        <div class="form-group">
        <label for="description">توضیحات محصول</label>
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="توضیحات محصول را وارد کنید"></textarea>
    </div>

        <div class="form-group">
            <label>دسته‌بندی</label>
            <select name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>تگ‌ها</label>
            <select name="tags[]" class="form-control" multiple>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>قیمت</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label>تصویر شاخص</label>
            <input type="file" name="main_image" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label>گالری تصاویر</label>
            <input type="file" name="gallery_images[]" class="form-control-file" multiple>
        </div>

        <button type="submit" class="btn btn-primary">ایجاد محصول</button>
    </form>
</div>
</body>
</html>
