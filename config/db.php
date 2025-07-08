<?php
$host = 'localhost'; // or 'localhost'
$db   = 'blog';  // your local database name
$user = 'root';      // default XAMPP username
$pass = '';          // default XAMPP password is empty

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>