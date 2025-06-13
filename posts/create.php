<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header( "Location: ../auth/login.php");
    exit;
}
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Create New Post</h2>
<form method="post" action="">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="6" cols="40" required></textarea><br><br>

    <input type="submit" value="Add Post">
</form>
<a href="../index.php">← Back to Home</a>