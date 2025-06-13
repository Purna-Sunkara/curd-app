<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // or "auth/login.php" for index.php
    exit();
}

include('../config/db.php');
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM posts WHERE id=$id");
header("Location: ../index.php");
?>
