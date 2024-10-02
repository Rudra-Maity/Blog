<?php
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $postId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($postId) {
       require 'conn.php';
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $postId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete post']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid post ID']);
    }
}
