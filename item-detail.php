<?php
session_start();
require_once 'config/db.php';

// Sample Data for testing
$item = [
    'id' => 1,
    'title' => 'Used Dell Core i5 Laptop (8GB RAM / 256GB SSD)',
    'category' => 'Computers & Laptops',
    'price' => 45000.00,
    'seller_name' => 'Kusal Perera',
    'location' => 'Colombo, Sri Lanka',
    'posted_date' => '2026-09-08',
    'description' => 'Good working condition Dell laptop. Suitable for academic work, programming, and light daily use. Battery backup around 2 hours. Comes with original charger.',
    'image' => 'https://via.placeholder.com/500x350'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - <?php echo $item['title']; ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .product-detail { display: flex; gap: 30px; flex-wrap: wrap; }
        .product-image { flex: 1; min-width: 300px; }
        .product-image img { width: 100%; border-radius: 8px; }
        .product-info { flex: 1; min-width: 300px; }
        .title { font-size: 1.8rem; color: #2c3e50; margin-bottom: 10px; }
        .price { font-size: 1.5rem; color: #27ae60; font-weight: bold; margin-bottom: 15px; }
        .meta { font-size: 0.9rem; color: #7f8c8d; margin-bottom: 15px; }
        .description { line-height: 1.6; color: #34495e; margin-bottom: 20px; }
        .btn-cart { background-color: #2980b9; color: white; border: none; padding: 12px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-cart:hover { background-color: #1f618d; }
    </style>
</head>
<body>

<div class="container">
    <div class="product-detail">
        <div class="product-image">
            <img src="<?php echo $item['image']; ?>" alt="Item Image">
        </div>
        <div class="product-info">
            <h1 class="title"><?php echo $item['title']; ?></h1>
            <p class="price">LKR <?php echo number_format($item['price'], 2); ?></p>
            <div class="meta">
                <p><strong>Category:</strong> <?php echo $item['category']; ?></p>
                <p><strong>Seller:</strong> <?php echo $item['seller_name']; ?></p>
                <p><strong>Location:</strong> <?php echo $item['location']; ?></p>
                <p><strong>Posted:</strong> <?php echo $item['posted_date']; ?></p>
            </div>
            <p class="description"><?php echo $item['description']; ?></p>
            
            <a href="cart.php?action=add&id=<?php echo $item['id']; ?>" class="btn-cart">Add to Cart</a>
        </div>
    </div>
</div>

</body>
</html>