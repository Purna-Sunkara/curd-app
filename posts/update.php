<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // or "auth/login.php" for index.php
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
<form method="post">
    <input name="title" value="<?= $post['title'] ?>"><br>
    <textarea name="content"><?= $post['content'] ?></textarea><br>
    <button type="submit">Update Post</button>
</form>
