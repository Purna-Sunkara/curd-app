<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

include('../config/db.php');
$title = $_POST['title'];
$content = $_POST['content'];
$stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $content);
$stmt->execute();
$stmt->close();
header("Location: ../index.php");
?>
