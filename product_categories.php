<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
}

require_once 'db.php';

// دریافت لیست دسته‌بندی‌ها همراه با نام دسته‌بندی والد
$query = "
    SELECT c1.id, c1.name AS category_name, c2.name AS parent_name 
    FROM categories c1
    LEFT JOIN categories c2 ON c1.parent_id = c2.id
";
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دسته‌بندی‌ها</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="direction: rtl; text-align: right;">
    <h2>مدیریت دسته‌بندی‌ها</h2>
    <a href="add_category.php" class="btn btn-success mb-3">افزودن دسته‌بندی جدید</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام دسته‌بندی</th>
                <th>دسته‌بندی والد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                    <td><?php echo $category['parent_name'] ? htmlspecialchars($category['parent_name']) : 'ندارد'; ?></td>
                    <td>
                        <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                        <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟');">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
