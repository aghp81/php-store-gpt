<?php
session_start();
$total_quantity = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_quantity += $item['quantity'];
    }
}
echo $total_quantity;
