<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCycle - User Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; }
        .container { max-width: 800px; margin: 2.5rem auto; padding: 0 20px; }
        .profile-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .profile-header { display: flex; align-items: center; gap: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        .avatar { width: 80px; height: 80px; background: #27ae60; color: white; font-size: 2rem; font-weight: bold; border-radius: 50%; display: flex; justify-content: center; align-items: center; }
        .user-details h3 { font-size: 1.4rem; color: #2c3e50; }
        .user-details p { color: #7f8c8d; font-size: 0.95rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; color: #34495e; font-weight: 600; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; }
        .btn-update { background: #27ae60; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 1.5rem; }
    </style>
</head>
<body>

    <header>
        <h2>SmartCycle</h2>
        <a href="index.php">Back to Home</a>
    </header>

    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar">JD</div>
                <div class="user-details">
                    <h3>John Doe</h3>
                    <p>Role: Buyer / Seller</p>
                </div>
            </div>

            <form action="profile.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" value="John Doe">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" value="john@example.com" disabled style="background:#f9f9f9;">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" value="0771234567">
                    </div>
                    <div class="form-group">
                        <label>New Password (Optional)</label>
                        <input type="password" placeholder="Leave blank to keep same">
                    </div>
                </div>
                <button type="submit" class="btn-update">Update Profile</button>
            </form>
        </div>
    </div>

</body>
</html>