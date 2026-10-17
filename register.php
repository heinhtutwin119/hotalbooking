<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center" style="max-width: 600px">
        <h1 class="h3 my-4">Register</h1>
        <form action="_actions/create.php" method="post" class="mb-2">
            <input type="text" name="name"  class="form-control mb-2" placeholder="Name" required>
            <input type="text" name="email"  class="form-control mb-2" placeholder="Email" required>
            <input type="text" name="phone"  class="form-control mb-2" placeholder="Phone" required>
            <textarea name="address"  class="form-control mb-2" placeholder="Address" required></textarea>
            <input type="password" name="password"  class="form-control mb-2" placeholder="Password" required>

            <button class="btn btn-primary w-100">Register</button>
        </form>

        <a href="index.php">Login</a>
    </div>
</body>
</html>

<!-- <?php
session_start();
?> -->
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input { padding: 8px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <h1>Create New User</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <form method="POST" action="_actions/create.php">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required>
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" required>
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" required>
        </div>
        
        <div class="form-group">
            <label>Password (min 8 characters)</label>
            <input type="password" name="password" required minlength="8">
        </div>
        
        <button type="submit">Create User</button>
    </form>
</body>
</html> -->