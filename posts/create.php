<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header( "Location: ../auth/login.php");
    exit;
}
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $errors = [];

    if (empty($title)) $errors[] = "Title is required.";
    if (strlen($title) > 255) $errors[] = "Title must be less than 255 characters.";
    if (empty($content)) $errors[] = "Content is required.";

    if (empty($errors)) {
        $title = mysqli_real_escape_string($conn, $title);
        $content = mysqli_real_escape_string($conn, $content);

        $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        if (mysqli_query($conn, $query)) {
            header("Location: ../index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Code change: Prepared statement for deleting a post
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Create New Post</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Content:</label>
            <textarea name="content" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Post</button>
        <a href="../index.php" class="btn btn-secondary">← Back to Home</a>
    </form>
</div>
</body>
</html>