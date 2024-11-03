<?php
// session_start();
$pageTitle = 'خانه | فروشگاه اینترنتی';
include 'header.php';

$products = [
    ['id' => 1, 'name' => 'محصول 1', 'price' => 100000, 'image' => 'images/product1.jpg'],
    ['id' => 2, 'name' => 'محصول 2', 'price' => 150000, 'image' => 'images/product2.jpg'],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    if (!isset($_SESSION['cart'][$product_id])) {
        foreach ($products as $product) {
            if ($product['id'] == $product_id) {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
                break;
            }
        }
    } else {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">قیمت: <?php echo number_format($product['price']); ?> تومان</p>
                        <form action="index.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-primary">افزودن به سبد خرید</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
