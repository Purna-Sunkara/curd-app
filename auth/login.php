<?php
session_start();
require_once '../config/db.php';

// Server-side validation
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username'])) $errors[] = "Username is required.";
    if (empty($_POST['password']) || strlen($_POST['password']) < 6) $errors[] = "Password must be at least 6 characters.";

    // Only proceed if no errors
    if (empty($errors)) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role']; // Add this line
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Invalid credentials!";
            }
        } else {
            $error = "Invalid credentials!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5" style="max-width:400px;">
    <h2 class="mb-4">Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="mt-3">
        <a href="register.php">Don't have an account? Register</a>
    </div>
</div>
</body>
</html>

