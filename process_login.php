<?php
session_start();
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $login_query->bind_param("s", $email);
    $login_query->execute();
    $result = $login_query->get_result();

    if($result->num_rows == 1){
        //user found
        $user = $result->fetch_assoc();
        if(password_verify($password, $user["password"])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();

    }
    else{
        echo "Incorrect password";
    }
}
else{
    echo "No user found with this email";
}
}
?>