<?php
session_start();
include 'config/db.php'; // DB Connection එකක් තියෙනවා නම්

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Order එක Process කිරීමේ Logic එක
    unset($_SESSION['cart']);
    $message = "Order placed successfully! Thank you for buying with SmartCycle.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Checkout</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; text-align: center; }
        .container { max-width: 600px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn { display: inline-block; width: 100%; background: #27ae60; color: white; border: none; padding: 12px; font-size: 1rem; border-radius: 5px; cursor: pointer; margin-top: 1rem; }
        .btn:hover { background: #219150; }
        .alert { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>

<header>
    <h1>SmartCycle Checkout</h1>
</header>

<div class="container">
    <?php if ($message): ?>
        <div class="alert"><?php echo $message; ?></div>
        <a href="login.php" style="text-align: center; display: block;">Return to Home</a>
    <?php else: ?>
        <h2>Order Summary</h2>
        <p>Please confirm your details to place the order.</p>
        <form method="POST">
            <label for="address">Delivery Address:</label><br>
            <textarea id="address" name="address" rows="4" style="width: 100%; margin-top: 8px;" required></textarea>
            
            <button type="submit" class="btn">Confirm Order</button>
        </form>
    <?php endif; ?>
</div>

</body>