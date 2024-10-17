<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/loginstyle.css">
    </head>
    <body>
    <div class="login-container">
        <h2>User Login</h2>
        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message"><?php echo $_GET['error']; ?></div>
        <?php endif; ?>
        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        </div>
    </body>
</html>