<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

include('../config/db.php');

// Validate and sanitize the id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Use prepared statement to fetch the post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Prepared statement for update
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../index.php");
    exit;
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
