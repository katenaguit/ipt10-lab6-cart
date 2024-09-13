<?php
session_start();
require 'products.php';

function generateOrderCode($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$order_code = generateOrderCode();
$filename = "orders-$order_code.txt";
$order_date = date('Y-m-d H:i:s');
$total_price = 0;

$file = fopen($filename, 'w');

fwrite($file, "Order Code: $order_code\n");
fwrite($file, "Date and Time Ordered: $order_date\n\n");
fwrite($file, "Order Items:\n");

foreach ($_SESSION['cart'] as $item) {
    fwrite($file, "Product ID: " . $item['id'] . "\n");
    fwrite($file, "Product Name: " . $item['name'] . "\n");
    fwrite($file, "Price: " . $item['price'] . " PHP\n\n");
    $total_price += $item['price'];
}

fwrite($file, "Total Price: " . $total_price . " PHP\n");

fclose($file);

$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your purchase! We look forward to serving you again!</p>
    <p><strong>Order Code:</strong> <?php echo htmlspecialchars($order_code); ?></p>
    <p><strong>Date and Time Ordered:</strong> <?php echo htmlspecialchars($order_date); ?></p>
    <p><strong>Total Price:</strong> <?php echo htmlspecialchars($total_price); ?> PHP</p>
</body>
</html>
