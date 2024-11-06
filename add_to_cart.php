<?php
//session_start();

// بررسی وجود سبد خرید
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// دریافت شناسه محصول و افزودن به سبد
$product_id = $_POST['product_id'];
if (!isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = 0;
}
$_SESSION['cart'][$product_id]++;

// محاسبه تعداد کل محصولات در سبد
$totalItems = array_sum($_SESSION['cart']);

// ارسال تعداد کل به عنوان پاسخ
echo $totalItems;
