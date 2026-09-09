<?php
// insert Database connection 
require_once 'config/db.php';

$message = '';
$error = '';

// after submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
   
    // Image Upload Process එක
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "assets/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
       
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
       
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // DB Query 
            $message = "E-waste item listed successfully!";
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Please upload an image of the item.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Sell E-Waste</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; }
        .container { max-width: 650px; margin: 2.5rem auto; padding: 0 20px; }
        .card { background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card h2 { color: #2c3e50; margin-bottom: 0.5rem; text-align: center; }
        .card p { color: #7f8c8d; text-align: center; margin-bottom: 1.5rem; font-size: 0.9rem; }
       
        .alert-success { background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; text-align: center; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; text-align: center; }
       
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; color: #34495e; font-weight: 600; font-size: 0.9rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 0.95rem; outline: none; }
        .form-group textarea { height: 100px; resize: vertical; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #e67e22; }
       
        .btn-submit { width: 100%; padding: 0.85rem; background: #e67e22; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { background: #d35400; }
    </style>
</head>
<body>

    <header>
        <h2>SmartCycle</h2>
        <a href="index.php">Back to Home</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Post E-Waste Item</h2>
            <p>List your unused electronic items or scrap for recycling</p>

            <?php if ($message): ?>
                <div class="alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="sell-item.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Item Title</label>
                    <input type="text" name="title" placeholder="e.g. Used Dell Laptop / Old Circuit Boards" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="computers">Computers & Laptops</option>
                        <option value="mobiles">Mobile Phones & Tablets</option>
                        <option value="appliances">Home Appliances</option>
                        <option value="components">Circuit Boards & Electronic Parts</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Expected Price (LKR)</label>
                    <input type="number" name="price" placeholder="5000" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Item Description & Condition</label>
                    <textarea name="description" placeholder="Describe working condition, defects, or specs..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Item Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="btn-submit">Publish Listing</button>
            </form>
        </div>
    </div>

</body>
</html>
