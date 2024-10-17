<?php
$host = 'localhost';
$db = 'blog_db';
$user = 'root'; // Default Username
$pass = ''; //Default pass

$conn = new mysqli($host, $user, $pass, $db);

if(!$conn){
    die('Connection failed: ' . $conn->connect_error);
}
?>