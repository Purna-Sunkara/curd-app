<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<h2>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h2>
<p><a href="posts/create.php">Create Post</a> | <a href="auth/logout.php">Logout</a></p>
