<?php
session_start();
require_once '../config/db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = 'user'; // default role

    // Server-side validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Only proceed if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            $success = "Registration successful. <a href='login.php'>Login now</a>";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}

// Example of the suggested code change applied to a DELETE operation
$id = 1; // This should be set to the id you want to delete
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5" style="max-width:400px;">
    <h2 class="mb-4">Register</h2>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" required placeholder="Username" autofocus>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" required placeholder="Password">
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>
    <div class="mt-3">
        <a href="login.php">Already have an account? Login</a>
    </div>
</div>
</body>
</html>
