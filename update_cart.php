<?php
session_start();

if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action == 'increase') {
        $_SESSION['cart'][$product_id]['quantity']++;
    } elseif ($action == 'decrease') {
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    // محاسبه تعداد کل محصولات در سبد خرید
    $total_quantity = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_quantity += $item['quantity'];
    }
    echo $total_quantity;
}
