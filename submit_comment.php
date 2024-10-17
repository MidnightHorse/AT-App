<?php
session_start(); // to use session for user_id
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['content']) && !empty($_POST['content'])) {
        $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $user_id = $_SESSION['user_id']; // assuming the user is logged in

        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // redirect back to the post page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>