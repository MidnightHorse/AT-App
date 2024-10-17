<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Dashboard</title>
    </head>
    <body>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>This is a protected page. You can only see this if you're logged in.</p>
        <a href="logout.php">Logout</a>
    </body>
</html>