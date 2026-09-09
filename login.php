<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - Account Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .auth-container { background: white; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 380px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-header h2 { color: #2c3e50; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .auth-header p { color: #7f8c8d; font-size: 0.9rem; }
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

    <div class="auth-container">
        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Log in to access SmartCycle</p>
        </div>
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

</body>
</html>