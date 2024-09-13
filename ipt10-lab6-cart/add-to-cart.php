<?php
session_start();
require 'products.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    foreach ($products as $product) {
        if ($product['id'] == $product_id) {
            $_SESSION['cart'][] = $product;
            break;
        }
    }
}

header('Location: cart.php');
exit();
