<?php
// session_start();
$pageTitle = 'سبد خرید';
include 'header.php';

if (isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    
    if ($_POST['action'] == 'increase') {
        $_SESSION['cart'][$product_id]['quantity']++;
    } elseif ($_POST['action'] == 'decrease') {
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;
$total_quantity = 0;

foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
    $total_quantity += $item['quantity'];
}
?>

<div class="container mt-4">
    <h3>سبد خرید شما</h3>
    <?php if (!empty($cart_items)): ?>
        <table class="table">
            <thead>
            <tr>
                <th>نام محصول</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>جمع کل</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart_items as $product_id => $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo number_format($item['price']); ?> تومان</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'] * $item['quantity']); ?> تومان</td>
                    <td>
                        <form action="cart.php" method="post" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button onclick="updateCart('<?php echo $product_id; ?>', 'increase')" class="btn btn-success btn-sm">+</button>

                        </form>
                        <form action="cart.php" method="post" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button onclick="updateCart('<?php echo $product_id; ?>', 'decrease')" class="btn btn-danger btn-sm">-</button>

                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- نمایش جمع کل قیمت و تعداد محصولات -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <h5>تعداد کل محصولات: <?php echo $total_quantity; ?></h5>
            <h5>جمع کل: <?php echo number_format($total_price); ?> تومان</h5>
        </div>

    <?php else: ?>
        <p>سبد خرید شما خالی است.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateCart(productId, action) {
    $.ajax({
        url: 'update_cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            action: action
        },
        success: function(response) {
            $('#cart-count').text(response); // به‌روزرسانی تعداد در آیکون سبد
        }
    });
}
</script>


<?php include 'footer.php'; ?>
