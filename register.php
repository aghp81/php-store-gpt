<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // بررسی تکراری بودن نام کاربری
    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->rowCount() > 0) {
        echo "این نام کاربری قبلاً ثبت شده است. لطفاً نام کاربری دیگری انتخاب کنید.";
    } else {
        // ثبت نام کاربر جدید
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $password, $role])) {
            echo "ثبت‌نام با موفقیت انجام شد.";
        } else {
            echo "خطا در ثبت‌نام.";
        }
    }
}
?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="نام کاربری" required>
    <input type="password" name="password" placeholder="رمز عبور" required>
    <select name="role" required>
        <option value="admin">مدیر</option>
        <option value="seller">فروشنده</option>
        <option value="customer">مشتری</option>
    </select>
    <button type="submit">ثبت‌نام</button>
</form>
