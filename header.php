<?php
session_start();
$total_quantity = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_quantity += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'فروشگاه اینترنتی'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">فروشگاه من</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">خانه</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <!-- آیکون سبد خرید به همراه تعداد محصولات -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1h1.11l.401 1.607L2.89 6H14a1 1 0 0 1 .98 1.197l-1.5 6A1 1 0 0 1 12.5 14H4a1 1 0 0 1-.98-.803L.607 2.607A.5.5 0 0 1 0 2.5v-1zM2.89 7L4 13h8.5l1.5-6H2.89z"/>
                            <path d="M4.5 16a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm7 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                        </svg>
                        <span id="cart-count" class="badge bg-danger rounded-pill"><?php echo $total_quantity; ?></span>

                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
