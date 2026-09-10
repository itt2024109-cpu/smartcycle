<?php
session_start();
require_once 'config/db.php';

// Sample Data Array (Database එකක් නොමැතිව UI එක පරීක්ෂා කිරීමට)
$items = [
    [
        'id' => 1,
        'title' => 'Used Dell Core i5 Laptop',
        'category' => 'computers',
        'price' => 45000.00,
        'location' => 'Colombo',
        'image' => 'https://via.placeholder.com/300x200'
    ],
    [
        'id' => 2,
        'title' => 'iPhone X - Display Damaged (For Parts)',
        'category' => 'mobiles',
        'price' => 12000.00,
        'location' => 'Kandy',
        'image' => 'https://via.placeholder.com/300x200'
    ],
    [
        'id' => 3,
        'title' => 'Old Motherboards & Circuit Scrap (5kg)',
        'category' => 'components',
        'price' => 8500.00,
        'location' => 'Galle',
        'image' => 'https://via.placeholder.com/300x200'
    ]
];

// Basic Search Filter Logic
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - E-Waste Marketplace</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 1rem; }
        
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 20px; }
        .page-title { text-align: center; color: #2c3e50; margin-bottom: 1.5rem; }
        
        /* Search and Filter Section */
        .filter-section { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .filter-form { display: flex; gap: 1rem; flex-wrap: wrap; }
        .filter-form input, .filter-form select { flex: 1; min-width: 200px; padding: 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 0.95rem; }
        .btn-filter { padding: 0.75rem 1.5rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn-filter:hover { background: #219150; }
        
        /* Product Grid Section */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-4px); }
        .product-card img { width: 100%; height: 180px; object-fit: cover; }
        .product-info { padding: 1.2rem; }
        .product-title { font-size: 1.1rem; color: #2c3e50; font-weight: bold; margin-bottom: 0.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .product-price { color: #e67e22; font-weight: bold; font-size: 1.2rem; margin-bottom: 0.5rem; }
        .product-location { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 1rem; }
        .btn-view { display: block; width: 100%; text-align: center; padding: 0.6rem; background: #3498db; color: white; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background 0.2s; }
        .btn-view:hover { background: #2980b9; }
    </style>
</head>
<body>

    <header>
        <h2>SmartCycle</h2>
        <div>
            <a href="sell-item.php">Sell Item</a>
            <a href="cart.php">Cart</a>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Explore E-Waste Items</h1>

        <!-- Search & Filter Bar -->
        <div class="filter-section">
            <form action="marketplace.php" method="GET" class="filter-form">
                <input type="text" name="search" placeholder="Search items (e.g. Laptop, Circuit)..." value="<?php echo htmlspecialchars($search_query); ?>">
                <select name="category">
                    <option value="">All Categories</option>
                    <option value="computers" <?php if($selected_category == 'computers') echo 'selected'; ?>>Computers & Laptops</option>
                    <option value="mobiles" <?php if($selected_category == 'mobiles') echo 'selected'; ?>>Mobile Phones & Tablets</option>
                    <option value="appliances" <?php if($selected_category == 'appliances') echo 'selected'; ?>>Home Appliances</option>
                    <option value="components" <?php if($selected_category == 'components') echo 'selected'; ?>>Circuit Boards & Parts</option>
                </select>
                <button type="submit" class="btn-filter">Search</button>
            </form>
        </div>

        <!-- Products List -->
        <div class="product-grid">
            <?php foreach ($items as $item): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image">
                    <div class="product-info">
                        <div class="product-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="product-price">LKR <?php echo number_format($item['price'], 2); ?></div>
                        <div class="product-location">Location: <?php echo htmlspecialchars($item['location']); ?></div>
                        <a href="item-detail.php?id=<?php echo $item['id']; ?>" class="btn-view">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>