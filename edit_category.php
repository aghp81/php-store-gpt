<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
}

require_once 'db.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $query = "SELECT * FROM categories WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $categoryId]);
    $category = $stmt->fetch();

    if (!$category) {
        header("Location: product_categories.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : NULL;

    if (!empty($name)) {
        $updateQuery = "UPDATE categories SET name = :name, parent_id = :parent_id WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute(['name' => $name, 'parent_id' => $parent_id, 'id' => $categoryId]);
        header("Location: product_categories.php");
        exit();
    }
}

// دریافت لیست دسته‌بندی‌ها برای نمایش در انتخاب والد
$query = "SELECT * FROM categories WHERE id != :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $categoryId]);
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش دسته‌بندی</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="direction: rtl; text-align: right;">
    <h2>ویرایش دسته‌بندی</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">نام دسته‌بندی</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="parent_id">دسته‌بندی والد (اختیاری)</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">بدون والد</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $category['parent_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        <a href="product_categories.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>
</body>
</html>

