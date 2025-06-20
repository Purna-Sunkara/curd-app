<?php
$host = '127.0.0.1'; // or 'localhost'
$db   = 'blog';  // your local database name
$user = 'root';      // default XAMPP username
$pass = 'Blog@125#';          // default XAMPP password is empty

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
