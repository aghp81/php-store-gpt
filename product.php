<?php
$pageTitle = 'جزئیات محصول';
include 'header.php';

$products = [
    1 => ['id' => 1, 'name' => 'محصول 1', 'price' => 100000, 'description' => 'توضیحات محصول 1', 'image' => 'images/product1.jpg'],
    2 => ['id' => 2, 'name' => 'محصول 2', 'price' => 150000, 'description' => 'توضیحات محصول 2', 'image' => 'images/product2.jpg'],
];
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = isset($products[$product_id]) ? $products[$product_id] : null;

if (!$product) {
    echo "محصول مورد نظر یافت نشد.";
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
            <h3><?php echo $product['name']; ?></h3>
            <p>قیمت: <?php echo number_format($product['price']); ?> تومان</p>
            <p><?php echo $product['description']; ?></p>

            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" name="add_to_cart" class="btn btn-primary">افزودن به سبد خرید</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
