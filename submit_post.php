<?php
include 'db.php';
session_start(); // Start the session to access session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title and content are set and not empty
    if (isset($_POST['title']) && isset($_POST['content']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        
        // Get the user_id from the session
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id']; // Use the logged-in user's ID from the session
        } else {
            // Handle case where user is not logged in
            die("You must be logged in to post."); 
        }

        // Prepare the SQL statement
        $sql = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', $user_id)";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "New post created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please fill in both fields.";
    }
}

$conn->close();
?>
