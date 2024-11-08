<?php
// بررسی نقش کاربر
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    echo "شما دسترسی لازم برای مشاهده این صفحه را ندارید.";
    exit;
}
?>

