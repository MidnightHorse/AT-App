<?php
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_user_query = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $check_user_query->bind_param("ss", $email, $username);
    $check_user_query->execute();
    $result = $check_user_query->get_result();

    if($result->num_rows > 0){
        echo "User already exists with this email or username";
    }
    else{
        $insert_user_query = $conn->prepare("INSERT into users (username, email, password) VALUES (?, ?, ?)");
        $insert_user_query->bind_param("sss", $username, $email, $hashed_password);

        if($insert_user_query->execute()){
            header("Location: login.php");
            exit();
        }
        else{
            echo "Error: " . $conn->error;
        }
    }
}
?>