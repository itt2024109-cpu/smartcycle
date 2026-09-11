<?php
session_start();
require_once 'config/db.php';

// ඩේටාබේස් එකෙන් අලුතින්ම දමා ඇති අයිතම 4ක් ලබා ගැනීම
$result = $conn->query("SELECT * FROM items ORDER BY created_at DESC LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - E-Waste Recycling & Marketplace</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
        
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        header h2 { font-size: 1.6rem; letter-spacing: 0.5px; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; }
        .nav-links a:hover { color: #3498db; }

        /* Hero Section with Local Background Image */
        .hero { 
            background: linear-gradient(rgba(30, 60, 114, 0.85), rgba(0, 176, 155, 0.85)), url('/smartcycle/assets/images/hero-bg.jpg'); 
            background-size: cover;
            background-position: center;
            color: white; 
            text-align: center; 
            padding: 6.5rem 2rem; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            gap: 1.2rem; 
            box-shadow: inset 0 -10px 20px rgba(0,0,0,0.1);
        }
        .hero h1 { font-size: 3.2rem; font-weight: 700; letter-spacing: -0.5px; text-shadow: 0 2px 10px rgba(0,0,0,0.15); }
        .hero p { font-size: 1.2rem; color: #e2e8f0; max-width: 650px; line-height: 1.6; text-shadow: 0 1px 5px rgba(0,0,0,0.1); }
        .btn-browse { background: #ffffff; color: #1e3c72; padding: 0.9rem 2.4rem; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 1.05rem; transition: all 0.3s ease; margin-top: 0.8rem; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .btn-browse:hover { background: #f8fafc; transform: translateY(-3px); box-shadow: 0 6px 22px rgba(0,0,0,0.2); }

        /* Main Content Container */
        .container { max-width: 1100px; margin: 3rem auto; padding: 0 20px; width: 100%; flex-grow: 1; }
        .section-title { font-size: 1.7rem; color: #2c3e50; margin-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; font-weight: 700; }

        /* Items Grid */
        .items-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.8rem; margin-bottom: 3.5rem; }
        .item-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; }
        .item-card:hover { transform: translateY(-6px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        .item-img-container { width: 100%; height: 190px; background: #edf2f7; overflow: hidden; position: relative; }
        .item-img { width: 100%; height: 100%; object-fit: cover; }
        
        .item-content { padding: 1.3rem; display: flex; flex-direction: column; gap: 0.6rem; flex-grow: 1; }
        .item-category { font-size: 0.75rem; color: #2980b9; background: #e8f4f8; padding: 0.2rem 0.6rem; border-radius: 4px; width: fit-content; font-weight: 600; text-transform: uppercase; }
        .item-title { font-size: 1.1rem; font-weight: bold; color: #2c3e50; line-height: 1.4; }
        .item-price { font-size: 1.2rem; font-weight: bold; color: #27ae60; margin-top: auto; padding-top: 0.5rem; }

        /* Features Section */
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.8rem; margin-bottom: 3rem; }
        .feature-box { background: white; padding: 2.2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; transition: transform 0.2s; }
        .feature-box:hover { transform: translateY(-4px); }
        .feature-box h3 { color: #2c3e50; margin-bottom: 0.8rem; font-size: 1.25rem; font-weight: 600; }
        .feature-box p { color: #718096; font-size: 0.95rem; line-height: 1.6; }

        /* Footer */
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

<!-- Hero Section -->
<section class="hero">
    <h1>Recycle Smarter, Live Greener</h1>
    <p>Turn your old electronics, computers, and e-waste into value while helping protect the environment through responsible recycling.</p>
    <a href="/smartcycle/item-detail.php" class="btn-browse">Browse E-Waste Items</a>
</section>

<div class="container">
    <!-- Latest E-Waste Items Section -->
    <h3 class="section-title">Recently Listed E-Waste</h3>
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
                        <div class="item-price">LKR <?php echo number_format($item['price'], 2); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color: #7f8c8d; grid-column: 1/-1; text-align: center; padding: 2rem; background: white; border-radius: 10px;">No e-waste items listed yet. Be the first to <a href="/smartcycle/sell-item.php" style="color: #2980b9; text-decoration: none; font-weight: bold;">sell an item</a>!</p>
        <?php endif; ?>
    </div>

    <!-- Why Choose SmartCycle Section -->
    <h3 class="section-title">Why Choose SmartCycle?</h3>
    <div class="features">
        <div class="feature-box">
            <h3>Eco-Friendly Disposal</h3>
            <p>Prevent hazardous electronic waste from ending up in landfills and damaging our environment.</p>
        </div>
        <div class="feature-box">
            <h3>Easy Marketplace</h3>
            <p>Quickly list your unused laptops, mobiles, and circuit components with just a few clicks.</p>
        </div>
        <div class="feature-box">
            <h3>Community Driven</h3>
            <p>Connect directly with local buyers and recyclers within your community efficiently.</p>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2026 SmartCycle. All rights reserved.</p>
</footer>

</body>
</html>