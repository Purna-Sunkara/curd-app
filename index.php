<?php
require_once 'config/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// --- Delete Post ---
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// --- Search ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
$params = [];
$types = '';

if ($search !== '') {
    $where = "WHERE title LIKE ? OR content LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types = 'ss';
}

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Count total posts
$count_sql = "SELECT COUNT(*) FROM posts " . ($where ? $where : '');
$count_stmt = $conn->prepare($count_sql);
if ($where) $count_stmt->bind_param($types, ...$params);
$count_stmt->execute();
$count_stmt->bind_result($total_posts);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total_posts / $limit);

// Fetch posts
$sql = "SELECT * FROM posts " . ($where ? $where : '') . " ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($where) {
    $all_params = array_merge($params, [$limit, $offset]);
    $stmt->bind_param($types . "ii", ...$all_params);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { padding: 2rem; }
        .container { max-width: 700px; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>
        <a class="btn btn-primary" href="posts/create.php">Create Post</a>
        <a class="btn btn-secondary" href="auth/logout.php">Logout</a>
    </p>

    <!-- Search Form -->
    <form class="mb-3" method="get" action="">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <!-- Posts List -->
    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group mb-3">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h5><?= htmlspecialchars($row['title']) ?></h5>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <a href="posts/update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info">No posts found.</div>
    <?php endif; ?>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(['search' => $search, 'page' => $i]) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>
