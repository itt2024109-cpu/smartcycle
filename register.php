<?php
session_start();
require_once 'config/db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        
        // Email එක කලින් භාවිත කර ඇත්දැයි පරීක්ෂා කිරීම
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "මෙම විද්‍යුත් තැපෑලෙන් දැනටමත් ගිණුමක් සාදා ඇත!";
        } else {
            // Password එක Secure ලෙස Hash කිරීම
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Database එකට Insert කිරීම
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                // Register වූ පසු කෙලින්ම Login page එකට Redirect කිරීම
                header("Location: login.php?registered=success");
                exit();
            } else {
                $error = "ගිණුම සෑදීමේදී දෝෂයක් සිදු විය! කරුණාකර නැවත උත්සාහ කරන්න.";
            }
            $stmt->close();
        }
        $check_stmt->close();
    } else {
        $error = "කරුණාකර සියලුම විස්තර ඇතුළත් කරන්න!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Register Account</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; min-height: 100vh; display: flex; flex-direction: column; }
        
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header h2 { font-size: 1.5rem; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; font-size: 0.95rem; }
        .nav-links a:hover { color: #2980b9; }

        .main-container { flex: 1; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .auth-container { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 1.5rem; }
        .auth-header h2 { color: #2c3e50; font-size: 1.8rem; margin-bottom: 0.5rem; }
        
        .error-message { background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem; text-align: center; border: 1px solid #f5c6cb; }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; color: #34495e; font-weight: 600; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #cccccc; border-radius: 6px; font-size: 0.95rem; outline: none; }
        .form-group input:focus { border-color: #2980b9; }
        
        .btn-submit { width: 100%; padding: 0.85rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { background: #219150; }
        
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
                <h2>Create Account</h2>
                <p>Register to start using SmartCycle</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Register</button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="login.php">Login Here</a>
            </div>
        </div>
    </div>

</body>
</html>