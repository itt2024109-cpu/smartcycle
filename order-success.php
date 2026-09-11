<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /smartcycle/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ඇණවුම සාර්ථකව සිදු වූ පසු cart එක හිස් කිරීම (Clear cart)
$clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$clear_cart->bind_param("i", $user_id);
$clear_cart->execute();
$clear_cart->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Order Successful</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .success-card { background: white; padding: 3rem 2.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; max-width: 500px; width: 100%; }
        .success-icon { font-size: 4rem; color: #27ae60; margin-bottom: 1rem; }
        h2 { color: #2c3e50; margin-bottom: 0.5rem; }
        p { color: #7f8c8d; margin-bottom: 2rem; font-size: 1rem; }
        .btn-home { background: #2980b9; color: white; padding: 0.8rem 2rem; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background 0.2s; }
        .btn-home:hover { background: #2471a3; }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">&#10004;</div>
    <h2>Order Placed Successfully!</h2>
    <p>Thank you for choosing SmartCycle. Your order has been successfully placed and your cart has been cleared.</p>
    <a href="/smartcycle/item-detail.php" class="btn-home">Continue Shopping</a>
</div>

</body>
</html>