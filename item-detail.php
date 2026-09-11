<?php
session_start();
require_once 'config/db.php';

// Add to cart ක්‍රියාවලිය හැසිරවීම
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /smartcycle/login.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $item_id = intval($_POST['item_id']);

    // Check if item already exists in cart for this user
    $check_stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND item_id = ?");
    if ($check_stmt) {
        $check_stmt->bind_param("ii", $user_id, $item_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            $cart_stmt = $conn->prepare("INSERT INTO cart (user_id, item_id) VALUES (?, ?)");
            if ($cart_stmt) {
                $cart_stmt->bind_param("ii", $user_id, $item_id);
                $cart_stmt->execute();
                $cart_stmt->close();
            }
        }
        $check_stmt->close();
    }

    // Redirect to cart page
    header("Location: /smartcycle/cart.php");
    exit();
}

// ඩේටාබේස් එකෙන් අයිතම සහ ඒවා එකතු කළ පරිශීලකයින්ගේ නම් ලබා ගැනීම
$query = "SELECT items.*, users.name AS seller_name FROM items JOIN users ON items.user_id = users.id ORDER BY items.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Available E-Waste Items</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
        
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        header h2 { font-size: 1.5rem; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; }
        .nav-links a:hover { color: #3498db; }

        .container { max-width: 1200px; margin: 2.5rem auto; padding: 0 20px; width: 100%; flex-grow: 1; }
        .page-title { color: #2c3e50; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .page-subtitle { color: #7f8c8d; margin-bottom: 2rem; font-size: 1rem; }

        /* Items Grid Layout */
        .items-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
        .item-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; }
        .item-card:hover { transform: translateY(-5px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
        
        .item-img-container { width: 100%; height: 200px; background: #eee; position: relative; overflow: hidden; }
        .item-img { width: 100%; height: 100%; object-fit: cover; }
        
        .item-content { padding: 1.5rem; display: flex; flex-direction: column; gap: 0.8rem; flex-grow: 1; }
        .item-category { font-size: 0.8rem; color: #2980b9; background: #e8f4f8; padding: 0.2rem 0.6rem; border-radius: 4px; width: fit-content; font-weight: 600; text-transform: uppercase; }
        .item-title { font-size: 1.15rem; font-weight: bold; color: #2c3e50; line-height: 1.4; }
        .item-desc { font-size: 0.9rem; color: #666; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .item-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: #888; border-top: 1px solid #eee; padding-top: 0.8rem; margin-top: auto; }
        .item-price { font-size: 1.2rem; font-weight: bold; color: #27ae60; }
        
        .btn-cart { display: block; width: 100%; padding: 0.75rem; background: #2980b9; color: white; border: none; border-radius: 6px; font-weight: bold; text-align: center; text-decoration: none; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; font-size: 1rem; }
        .btn-cart:hover { background: #2471a3; }

        .no-items { background: white; padding: 3rem; text-align: center; border-radius: 10px; color: #7f8c8d; grid-column: 1 / -1; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
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
    <h2 class="page-title">Available E-Waste Marketplace</h2>
    <p class="page-subtitle">Browse and purchase or recycle pre-owned electronic components and items from your community.</p>

    <div class="items-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="item-card">
                    <div class="item-img-container">
                        <img src="/smartcycle/assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image" class="item-img" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    </div>
                    <div class="item-content">
                        <span class="item-category"><?php echo htmlspecialchars($item['category']); ?></span>
                        <div class="item-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="item-desc"><?php echo htmlspecialchars($item['description']); ?></div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.3rem;">
                            <div class="item-price">LKR <?php echo number_format($item['price'], 2); ?></div>
                        </div>

                        <div class="item-meta">
                            <span>Seller: <strong><?php echo htmlspecialchars($item['seller_name']); ?></strong></span>
                            <span><?php echo date('Y-m-d', strtotime($item['created_at'])); ?></span>
                        </div>

                        <!-- Add to Cart Form -->
                        <form method="POST" action="">
                            <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-items">
                No e-waste items available right now. Be the first one to <a href="/smartcycle/sell-item.php" style="color: #2980b9; text-decoration: none; font-weight: bold;">list an item</a>!
            </div>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>&copy; 2026 SmartCycle. All rights reserved.</p>
</footer>

</body>
</html>