<?php
session_start();
require_once 'config/db.php';

// පරිශීලකයා ලොග් වී ඇද්දැයි පරීක්ෂා කිරීම
if (!isset($_SESSION['user_id'])) {
    header("Location: /smartcycle/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cart එකෙන් අයිතමයක් ඉවත් කිරීමේ කේතය
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $remove_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $remove_stmt->bind_param("ii", $cart_id, $user_id);
    $remove_stmt->execute();
    $remove_stmt->close();
    header("Location: /smartcycle/cart.php");
    exit();
}

// ඩේටාබේස් එකෙන් Cart එකේ ඇති අයිතම ලබා ගැනීම
$query = "SELECT cart.id AS cart_id, items.* FROM cart 
          JOIN items ON cart.item_id = items.id 
          WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Shopping Cart</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
        
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        header h2 { font-size: 1.5rem; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; }
        .nav-links a:hover { color: #3498db; }

        .container { max-width: 900px; margin: 2.5rem auto; padding: 0 20px; width: 100%; flex-grow: 1; }
        .page-title { color: #2c3e50; font-size: 1.8rem; margin-bottom: 1.5rem; font-weight: 700; }

        .cart-card { background: white; border-radius: 12px; padding: 2.5rem; box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
        
        .cart-item { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #edf2f7; padding: 1.2rem 0; gap: 1rem; flex-wrap: wrap; }
        .cart-item:last-child { border-bottom: none; }
        
        .item-info { display: flex; align-items: center; gap: 1.2rem; }
        .item-img { width: 85px; height: 85px; object-fit: cover; border-radius: 10px; background: #edf2f7; }
        .item-details h4 { color: #2c3e50; font-size: 1.15rem; margin-bottom: 0.3rem; }
        .item-details p { color: #718096; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        
        .item-price { font-size: 1.15rem; font-weight: bold; color: #27ae60; }
        .btn-remove { background: #fff5f5; color: #e53e3e; border: 1px solid #fed7d7; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; cursor: pointer; }
        .btn-remove:hover { background: #e53e3e; color: white; }

        .cart-summary { margin-top: 2rem; border-top: 2px solid #edf2f7; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .total-amount { font-size: 1.35rem; font-weight: bold; color: #2c3e50; }
        .btn-checkout { background: #27ae60; color: white; padding: 0.85rem 2.2rem; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 1rem; transition: background 0.2s; box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2); }
        .btn-checkout:hover { background: #219653; }

        /* Empty Cart Styling */
        .empty-cart { text-align: center; padding: 3.5rem 1rem; display: flex; flex-direction: column; gap: 1.2rem; align-items: center; }
        .empty-icon { font-size: 4rem; color: #cbd5e0; background: #f7fafc; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 0.5rem; }
        .empty-cart h3 { color: #2c3e50; font-size: 1.4rem; font-weight: 600; }
        .empty-cart p { color: #718096; font-size: 1rem; max-width: 400px; line-height: 1.5; }
        .btn-browse { background: #3498db; color: white; padding: 0.8rem 2rem; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.95rem; transition: background 0.2s; box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2); margin-top: 0.5rem; }
        .btn-browse:hover { background: #2980b9; }

        footer { background: #2c3e50; color: #bdc3c7; text-align: center; padding: 1.5rem; font-size: 0.9rem; margin-top: auto; }
    </style>
</head>
<body>

<header>
    <h2>SmartCycle</h2>
    <nav class="nav-links">
        <a href="/smartcycle/index.php">Home</a>
        <a href="/smartcycle/item-detail.php">Items</a>
        <a href="/smartcycle/sell-item.php">Sell Item</a>
        <a href="/smartcycle/cart.php">Cart</a>
        <a href="/smartcycle/profile.php">Profile</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/smartcycle/logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a>
        <?php else: ?>
            <a href="/smartcycle/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <h2 class="page-title">Shopping Cart</h2>

    <div class="cart-card">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php 
            $total = 0;
            while ($row = $result->fetch_assoc()): 
                $total += $row['price'];
            ?>
                <div class="cart-item">
                    <div class="item-info">
                        <img src="/smartcycle/assets/images/<?php echo htmlspecialchars($row['image']); ?>" alt="Item" class="item-img" onerror="this.src='https://via.placeholder.com/85?text=No+Image'">
                        <div class="item-details">
                            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p><?php echo htmlspecialchars($row['category']); ?></p>
                        </div>
                    </div>
                    <div class="item-price">LKR <?php echo number_format($row['price'], 2); ?></div>
                    <a href="/smartcycle/cart.php?remove=<?php echo $row['cart_id']; ?>" class="btn-remove" onclick="return confirm('Are you sure you want to remove this item?');">Remove</a>
                </div>
            <?php endwhile; ?>

            <div class="cart-summary">
                <div class="total-amount">Total: LKR <?php echo number_format($total, 2); ?></div>
                <a href="/smartcycle/checkout.php" class="btn-checkout">Proceed to Checkout</a>
            </div>

        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-icon">&#128722;</div>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any e-waste items to your cart yet. Explore our marketplace and start recycling or shopping!</p>
                <a href="/smartcycle/item-detail.php" class="btn-browse">Browse Items</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>&copy; 2026 SmartCycle. All rights reserved.</p>
</footer>

</body>
</html>