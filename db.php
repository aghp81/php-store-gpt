<?php
// اطلاعات اتصال به دیتابیس
$host = 'localhost';
$dbname = 'ecommerce_db';
$user = 'root';
$pass = '';

// اتصال با PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
