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
<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /smartcycle/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ඩේටාබේස් එකෙන් Cart එකේ total එක ගන්න
$query = "SELECT SUM(items.price) AS total FROM cart JOIN items ON cart.item_id = items.id WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$total = $result['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Checkout</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 600px; margin: 3rem auto; background: white; padding: 2.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; }
        h2 { color: #2c3e50; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; }
        input, textarea, select { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; background-color: #fff; }
        .total-box { font-size: 1.2rem; font-weight: bold; color: #27ae60; margin-bottom: 1.5rem; background: #eafaf1; padding: 1rem; border-radius: 6px; }
        .btn-submit { background: #27ae60; color: white; border: none; padding: 0.8rem; width: 100%; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background: #219653; }
    </style>
</head>
<body>

<header>
    <h2>SmartCycle</h2>
</header>

<div class="container">
    <h2>Checkout Details</h2>
    <div class="total-box">Total Amount: LKR <?php echo number_format($total, 2); ?></div>
    
    <form action="order-success.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required placeholder="Enter your name">
        </div>
        
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" required placeholder="Enter your phone number">
        </div>
        
        <div class="form-group">
            <label>Delivery Address</label>
            <textarea name="address" rows="3" required placeholder="Enter your address"></textarea>
        </div>

        <!-- Delivery Method -->
        <div class="form-group">
            <label>Delivery Method</label>
            <select name="delivery_method" required>
                <option value="">Select Delivery Method</option>
                <option value="Standard Delivery">Standard Delivery (2-3 Days) - LKR 350.00</option>
                <option value="Express Delivery">Express Delivery (Next Day) - LKR 600.00</option>
                <option value="Store Pickup">Store Pickup (Free)</option>
            </select>
        </div>

        <!-- Payment Method (COD Only) -->
        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" required>
                <option value="Cash on Delivery" selected>Cash on Delivery (COD)</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Confirm Order</button>
    </form>
</div>

</body>
</html>