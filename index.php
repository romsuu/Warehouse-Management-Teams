<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/a2/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="/a2/php/login.php">
            <input type="text" name="pincode" placeholder="Enter Pincode" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
