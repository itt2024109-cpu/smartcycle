<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Create Account</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .auth-container { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 420px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-header h2 { color: #2c3e50; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .auth-header p { color: #7f8c8d; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; color: #34495e; font-weight: 600; font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #cccccc; border-radius: 6px; font-size: 0.95rem; outline: none; }
        .form-group input:focus, .form-group select:focus { border-color: #27ae60; }
        .btn-submit { width: 100%; padding: 0.85rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { background: #219150; }
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666; }
        .auth-footer a { color: #27ae60; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Join SmartCycle Second-Hand Marketplace</p>
        </div>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="0771234567" required>
            </div>
            <div class="form-group">
                <label>Account Role</label>
                <select name="user_type" required>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
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

</body>
</html>