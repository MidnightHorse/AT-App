<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title> Create Post</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>
    <h1>Create a New Post</h1>
    <form action="submit_post.php" method ="POST">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Post Content" required></textarea>
        <button type="submit">Submit Post</button>
    </form>
</body>
</html>