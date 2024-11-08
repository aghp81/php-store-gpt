<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : NULL;

    if (!empty($name)) {
        $query = "INSERT INTO categories (name, parent_id) VALUES (:name, :parent_id)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['name' => $name, 'parent_id' => $parent_id]);
        header("Location: product_categories.php");
        exit();
    }
}

// دریافت لیست دسته‌بندی‌های موجود برای انتخاب دسته‌بندی والد
$query = "SELECT * FROM categories";
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن دسته‌بندی جدید</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="direction: rtl; text-align: right;">
    <h2>افزودن دسته‌بندی جدید</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">نام دسته‌بندی</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="parent_id">دسته‌بندی والد (اختیاری)</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">بدون والد</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">ذخیره</button>
        <a href="product_categories.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>
</body>
</html>
