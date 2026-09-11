<?php
session_start();
require_once 'config/db.php';

$error = "";

// Form එක Submit වූ පසු ක්‍රියාත්මක වන කොටස
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        
        // Database එකෙන් User විස්තර පරීක්ෂා කිරීම
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Password එක නිවැරදිදැයි Verify කිරීම
            if (password_verify($password, $user['password'])) {
                
                // Session එකේ User Data Save කිරීම
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Login වූ පසු item-detail.php වෙත Redirect කිරීම
                header("Location: item-detail.php");
                exit();
            } else {
                $error = "විස්තර අසත්‍යයි! කරුණාකර මුරපදය පරීක්ෂා කරන්න.";
            }
        } else {
            $error = "මෙම විද්‍යුත් තැපෑලට අදාළ ගිණුමක් හමු නොවීය!";
        }
        $stmt->close();
    } else {
        $error = "කරුණාකර සියලුම තොරතුරු ඇතුළත් කරන්න!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Account Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Navigation Header Styles */
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header h2 { font-size: 1.5rem; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; }
        .nav-links a:hover { color: #2980b9; }
        .nav-links a.active { color: #2980b9; font-weight: bold; }

        .main-container { flex: 1; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .auth-container { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 380px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 1.5rem; }
        .auth-header h2 { color: #2c3e50; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .auth-header p { color: #7f8c8d; font-size: 0.9rem; }
        
        .error-message { background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem; text-align: center; border: 1px solid #f5c6cb; }
        .success-message { background-color: #d4edda; color: #155724; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem; text-align: center; border: 1px solid #c3e6cb; }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; color: #34495e; font-weight: 600; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #cccccc; border-radius: 6px; font-size: 0.95rem; outline: none; }
        .form-group input:focus { border-color: #2980b9; }
        
        .btn-submit { width: 100%; padding: 0.85rem; background: #2980b9; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { background: #2471a3; }
        
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666; }
        .auth-footer a { color: #2980b9; text-decoration: none; font-weight: bold; }
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
        <a href="/smartcycle/login.php">Login</a>
    </nav>
</header>

    <div class="main-container">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Welcome Back</h2>
                <p>Log in to access SmartCycle</p>
            </div>

            <!-- Success Notification (Order Complete වූ පසු පෙන්වීමට) -->
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="success-message">
                    Order placed successfully! Thank you for buying with SmartCycle.
                </div>
            <?php endif; ?>

            <!-- Error Notification -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Login</button>
            </form>
            
            <div class="auth-footer">
                Don't have an account? <a href="register.php">Register Now</a>
            </div>
        </div>
    </div>

</body>
</html>