<?php
include 'db.php';
session_start();

$query = "
    SELECT posts.*, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    ORDER BY posts.created_at DESC
";
$result = mysqli_query($conn, $query);

$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) :'Guest';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>My Blog</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".toggle-comment-form").click(function(){
                    $(this).next(".comment-form").toggle();
                });
            });
        </script>
    </head>
    <body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-logo">Astronomy tracker</a>
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="navbar-auth">
                <a href="login.php" class="navbar-login">Login</a>
                <a href="register.php" class="navbar-register">Register</a>
            </div>
        </div>
    </nav>
    <main>
        <section class="post-container">
            <!-- Link to Create New Post -->
            <h2> All posts</h2>
            <!-- Loop through and display posts from the database -->
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
                <div class="post-box">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['content']; ?></p>
                    <small>Posted by: <?php echo $row['username']; ?> &ensp; Posted at: <?php echo $row['created_at']; ?></small>
                    <!-- Display Comments -->
                     <div class="headercoment"><h4>Comments:</h4></div>
                    <?php
                    // Fetch comments related to the current post
                    $post_id = $row['id'];
                    $comment_query = $comment_query = "
                    SELECT comments.content, comments.created_at, users.username 
                    FROM comments 
                    JOIN users ON comments.user_id = users.id 
                    WHERE comments.post_id = ? 
                    ORDER BY comments.created_at DESC";
                    $stmt = $conn->prepare($comment_query);
                    $stmt->bind_param("i", $post_id);
                    $stmt->execute();
                    $comment_result = $stmt->get_result();

                    // Loop through comments
                    while ($comment = mysqli_fetch_assoc($comment_result)) : ?>
                        <div class="comment">
                            <p><?php echo $comment['content']; ?></p>
                            <small>Commented by: <?php echo $comment['username']; ?> &ensp; Commented on: <?php echo $comment['created_at'];?></small>
                        </div>
                    <?php endwhile; ?>

                    <!-- Button to toggle comment form -->
                    <?php if (isset($_SESSION['user_id'])) : // Check if user is logged in ?>
                        <button class="toggle-comment-form">Add Comment</button>
                        <form class="comment-form" action="submit_comment.php" method="POST" style="display:none;">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <textarea name="content" required placeholder="Add a comment..."></textarea>
                            <button type="submit">Submit Comment</button>
                        </form>
                    <?php else : ?>
                        <p>You must be logged in to comment. <a href="login.php">Login here</a></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </section>
        <aside id="news-container">
            <h2>Astronomy News</h2>
            <!-- News will be displayed here by JavaScript -->
        </aside>
    </main>
    <script>
        async function fetchAstronomyNews() {
    try {
        // Add 'count=5' to fetch 5 different news items (APOD entries)
        const response = await fetch('https://api.nasa.gov/planetary/apod?api_key=yHYe6bNKAI7HrE7f6pBzAmffo9IKDCfUsjkUgdoW&count=6');
        const data = await response.json();
        
        // Log the data for debugging
        console.log("Fetched Data: ", data);
        
        // Check if the data is an array (multiple entries) or a single object
        if (!Array.isArray(data)) {
            displayNews([data]); // Wrap single object in an array
        } else {
            displayNews(data); // Multiple entries
        }
        
    } catch (error) {
        console.error("Error fetching astronomy news:", error);
    }
}

    function displayNews(newsData) {
        const newsContainer = document.getElementById('news-container');
        newsContainer.innerHTML = ''; // Clear previous content

        newsData.forEach(newsItem => {
            const truncatedExplanation = truncateText(newsItem.explanation, 100); // Limit explanation text to 100 characters
            const newsHTML = `
                <div class="news-box">
                    <h3>${newsItem.title}</h3>
                    <p>${truncatedExplanation} <a href="${newsItem.url}" target="_blank"><br>Learn more</br></a></p>
                </div>
            `;
            
            newsContainer.innerHTML += newsHTML; // Add the news item to the container
        });
    }

    // Function to truncate the text and add "..." if it's too long
    function truncateText(text, limit) {
        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    // Call the function to fetch and display the news
    fetchAstronomyNews();
    </script>
    </body>
</html>

<?php
//close the database connection
mysqli_close($conn);
?>