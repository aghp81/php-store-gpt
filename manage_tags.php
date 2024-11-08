<?php
session_start();
include 'db.php'; // فایل اتصال به دیتابیس
include 'check_role.php'; // بررسی نقش کاربر
// اضافه کردن فایل jdf.php فقط یک‌بار
require_once 'jdf.php';

// چک کردن نقش کاربر (فقط مدیر و فروشنده دسترسی دارند)
if (!in_array($_SESSION['role'], ['admin', 'seller'])) {
    echo "شما دسترسی لازم برای این بخش را ندارید.";
    exit;
}

// حذف تگ در صورت ارسال درخواست
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM tags WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: manage_tags.php");
    exit;
}

// ویرایش تگ در صورت ارسال درخواست
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $pdo->prepare("UPDATE tags SET name = ? WHERE id = ?");
        $stmt->execute([$name, $edit_id]);
        header("Location: manage_tags.php");
        exit;
    } else {
        echo "لطفاً نام جدیدی برای تگ وارد کنید.";
    }
}

// گرفتن لیست تگ‌ها و اطلاعات ایجادکننده
$stmt = $pdo->query("
    SELECT tags.id, tags.name, users.name AS creator_name, users.family_name AS creator_family_name, tags.created_at 
    FROM tags 
    JOIN users ON tags.created_by = users.id
");
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت تگ‌ها</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>مدیریت تگ‌ها</h2>

    <!-- لینک ایجاد تگ جدید -->
    <a href="create_tag.php" class="btn btn-primary mb-3">ایجاد تگ جدید</a>

    <!-- جدول نمایش تگ‌ها -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام تگ</th>
                <th>ایجاد شده توسط</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): 
                // تبدیل تاریخ میلادی به شمسی با استفاده از تابع jdf
                    $created_at = $tag['created_at'];
                    $jalali_date = jdate('Y/m/d', strtotime($created_at));
                    ?>
                <tr>
                    <td><?= htmlspecialchars($tag['id']) ?></td>
                    <td><?= htmlspecialchars($tag['name']) ?></td>
                    <td><?= htmlspecialchars($tag['creator_name'] . ' ' . $tag['creator_family_name']) ?></td>
                    <td><?= htmlspecialchars($jalali_date) ?></td>
                    <td>
                        <form action="manage_tags.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="edit_id" value="<?= $tag['id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($tag['name']) ?>" required>
                            <button type="submit" class="btn btn-warning btn-sm">ویرایش</button>
                        </form>
                        <a href="manage_tags.php?delete_id=<?= $tag['id'] ?>" onclick="return confirm('آیا از حذف این تگ مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
