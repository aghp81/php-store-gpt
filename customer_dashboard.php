<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}
echo "به پنل مشتری خوش آمدید!";
?>
<a href="logout.php">خروج</a>
