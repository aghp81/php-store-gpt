<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}
echo "به پنل فروشنده خوش آمدید!";
?>
<a href="logout.php">خروج</a>
