<?php
$host = 'localhost';
$user = 'root';
$pass = 'Purna@123'; // Leave empty if you're using XAMPP default
$dbname = 'blog';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
