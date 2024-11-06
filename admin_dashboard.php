<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
echo "به پنل مدیر خوش آمدید!";
?>
<a href="logout.php">خروج</a>
