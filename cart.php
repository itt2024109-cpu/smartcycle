<?php
session_start();
require_once 'config/db.php';

// sample session array (For Testing)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        [
            'id' => 1,
            'title' => 'Used Dell Core i5 Laptop',
            'category' => 'Computers & Laptops',
            'price' => 45000.00,
            'image' => 'assets/images/laptop.jpg'
        ]
    ];
}

// Item remove
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit();
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Shopping Cart</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; }
        
        .container { max-width: 900px; margin: 2rem auto; padding: 0 20px; }
        .cart-card { background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .cart-card h2 { color: #2c3e50; margin-bottom: 1.5rem; text-align: center; }
        
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .cart-table th, .cart-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        .cart-table th { background-color: #f8f9fa; color: #34495e; font-weight: 600; }
        
        .btn-remove { color: #e74c3c; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
        .btn-remove:hover { text-decoration: underline; }
        
        .cart-summary { display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #eee; padding-top: 1.5rem; }
        .total-amount { font-size: 1.3rem; font-weight: bold; color: #2c3e50; }
        
        .btn-checkout { padding: 0.85rem 2rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-checkout:hover { background: #219150; }
        
        .empty-msg { text-align: center; color: #7f8c8d; margin: 2rem 0; }
    </style>
</head>
<body>

    <header>
        <h2>SmartCycle</h2>
        <a href="index.php">Back to Home</a>
    </header>

    <div class="container">
        <div class="cart-card">
            <h2>Your Selected E-Waste Items</h2>

            <?php if (!empty($_SESSION['cart'])): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item Details</th>
                            <th>Category</th>
                            <th>Price (LKR)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $key => $item): 
                            $total_price += $item['price'];
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($item['title']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                <td>LKR <?php echo number_format($item['price'], 2); ?></td>
                                <td><a href="cart.php?action=remove&id=<?php echo $key; ?>" class="btn-remove">Remove</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <div class="total-amount">Total: LKR <?php echo number_format($total_price, 2); ?></div>
                    <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
                </div>
            <?php else: ?>
                <p class="empty-msg">Your cart is currently empty.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>