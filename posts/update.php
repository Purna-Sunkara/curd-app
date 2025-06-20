<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../config/db.php');
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$post = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    mysqli_query($conn, "UPDATE posts SET title='$title', content='$content' WHERE id=$id");
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Update Post</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title:</label>
            <input name="title" value="<?= htmlspecialchars($post['title']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Content:</label>
            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Post</button>
        <a href="../index.php" class="btn btn-secondary">← Back to Home</a>
    </form>
</div>
</body>
</html>
