<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id'];
    $tags = $_POST['tags'] ?? [];
    $price = $_POST['price'];
    $createdBy = $_SESSION['user_id'];

    // ذخیره تصویر شاخص
    $mainImagePath = 'uploads/' . basename($_FILES['main_image']['name']);
    move_uploaded_file($_FILES['main_image']['tmp_name'], $mainImagePath);

    // ذخیره اطلاعات محصول در دیتابیس
    $stmt = $pdo->prepare("INSERT INTO products (name, description,  category_id, price, main_image, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$productName, $description, $categoryId, $price, $mainImagePath, $createdBy]);
    $productId = $pdo->lastInsertId();

    // ذخیره تگ‌های محصول
    foreach ($tags as $tagId) {
        $stmt = $pdo->prepare("INSERT INTO product_tags (product_id, tag_id) VALUES (?, ?)");
        $stmt->execute([$productId, $tagId]);
    }

    // ذخیره تصاویر گالری
    foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['gallery_images']['name'][$key]) {
            $galleryImagePath = 'uploads/' . basename($_FILES['gallery_images']['name'][$key]);
            move_uploaded_file($tmpName, $galleryImagePath);

            $stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
            $stmt->execute([$productId, $galleryImagePath]);
        }
    }

    // هدایت به صفحه موفقیت یا لیست محصولات
    header("Location: manage_products.php");
    exit;
} else {
    echo "درخواست نامعتبر است.";
}
?>
