<?php
session_start();
require_once 'config/db.php';

// User log වී නැත්නම් Login page එකට redirect කිරීම
if (!isset($_SESSION['user_id'])) {
    header("Location: /smartcycle/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// පරිශීලකයාගේ විස්තර ලබා ගැනීම
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// පරිශීලකයා විසින් Post කර ඇති items ලබා ගැනීම
$items_stmt = $conn->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC");
$items_stmt->bind_param("i", $user_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
$items_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - User Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
        
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header h2 { font-size: 1.5rem; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; }
        .nav-links a:hover { color: #2980b9; }

        .container { max-width: 900px; margin: 2.5rem auto; padding: 0 20px; width: 100%; }
        
        .profile-card { background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.5rem; }
        .profile-info { display: flex; align-items: center; gap: 1.5rem; }
        .profile-avatar { width: 70px; height: 70px; background: #2980b9; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; }
        .profile-details h3 { color: #2c3e50; font-size: 1.3rem; margin-bottom: 0.3rem; }
        .profile-details p { color: #7f8c8d; font-size: 0.95rem; }
        
        .btn-logout { background: #e74c3c; color: white; padding: 0.6rem 1.2rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; }
        .btn-logout:hover { background: #c0392b; }

        .section-title { color: #2c3e50; margin-bottom: 1rem; font-size: 1.2rem; border-bottom: 2px solid #ddd; padding-bottom: 0.5rem; }
        
        .items-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
        .item-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
        .item-img { width: 100%; height: 160px; object-fit: cover; background: #eee; }
        .item-content { padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; flex-grow: 1; }
        .item-title { font-size: 1rem; font-weight: bold; color: #2c3e50; }
        .item-category { font-size: 0.85rem; color: #2980b9; background: #e8f4f8; padding: 0.2rem 0.5rem; border-radius: 4px; width: fit-content; }
        .item-price { font-size: 1rem; font-weight: bold; color: #27ae60; }
        .no-items { background: white; padding: 2rem; text-align: center; border-radius: 8px; color: #7f8c8d; grid-column: 1 / -1; }
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
        <a href="/smartcycle/logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <!-- Profile Header Card -->
    <div class="profile-card">
        <div class="profile-info">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
            </div>
            <div class="profile-details">
                <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
        <a href="/smartcycle/logout.php" class="btn-logout">Logout</a>
    </div>

    <!-- My Listed E-Waste Items -->
    <h3 class="section-title">My Listed E-Waste Items</h3>
    <div class="items-grid">
        <?php if ($items_result->num_rows > 0): ?>
            <?php while ($item = $items_result->fetch_assoc()): ?>
                <div class="item-card">
                    <img src="/smartcycle/assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image" class="item-img">
                    <div class="item-content">
                        <span class="item-category"><?php echo htmlspecialchars($item['category']); ?></span>
                        <div class="item-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="item-price">LKR <?php echo number_format($item['price'], 2); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-items">You haven't listed any e-waste items yet. <a href="/smartcycle/sell-item.php" style="color: #2980b9; text-decoration: none;">Sell an item now</a></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>