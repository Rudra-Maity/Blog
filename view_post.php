<?php
require 'session.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require 'conn.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch post data
    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $post_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found or you are not authorized to view this post.";
        exit();
    }
} else {
    echo "Invalid post ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post - <?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p class="text-muted">Published on: <?php echo date('F d, Y', strtotime($post['created_at'])); ?></p>
            <p class="text-muted">Tags: <?php echo htmlspecialchars($post['tags']); ?></p>
            
            <div class="mt-4">
                <!-- Display post content -->
                <?php echo nl2br($post['content']); ?>
            </div>

            <!-- Edit and Delete Buttons (Only show for the user who created the post) -->
            <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                <div class="mt-4">
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Edit</a>
                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
