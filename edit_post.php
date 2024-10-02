<?php
require 'session.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require 'conn.php';

if (isset($_GET['id']) ) {
    $post_id = $_GET['id'];

    // Fetch post data
    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $post_id, $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found or you are not authorized to edit this post.";
        exit();
    }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id=$_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'] ?? '';
    $status = $_POST['status'] ?? '';
    // require 'session.php';
    if(!empty($post_id) &&!empty($content) && !empty($title) && !empty($status)){
    $decy=decryptSessionID( $_SESSION['user_id']);
    $sql = "UPDATE posts SET title = ?, content = ?, tags = ?,status = ?, updated_at = NOW() WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);   
    $stmt->bind_param('ssssii', $title, $content, $tags,$status, $post_id, $_SESSION['username']);

    if ($stmt->execute()) {
        echo "Post updated successfully!";
        header("Location: dash.php");
        exit();
    } else {
        echo "Error updating post.";
    }
}else {
    echo json_encode(['success'=>false,'message'=>"content and title and status are requierd"]);
    exit();
}
}
?>

    <script>
        tinymce.init({
            selector: '.editor',
            plugins: 'link image code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | code'
        });
    </script>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- <h2>Edit Post</h2> -->
            <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']  )?>" method="POST" >
                <input type="text" value="<?= $post['id']?>" name="id" hidden required>
                <!-- Title Input -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <!-- Content Editor -->
                <div class="mb-3">
                    <label for="editor" class="form-label">Content</label>
                    <textarea class="editor" name="content"><?php echo html_entity_decode($post['content']); ?></textarea>
                </div>

                <!-- Tags Input -->
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags (Optional)</label>
                    <input type="text" class="form-control" id="tags" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>" placeholder="Add tags separated by commas">
                </div>
                <div class="mb-3">
                        <label for="postStatus" class="form-label">Status</label>
                        <?php echo $post['status']; ?>
                        <select class="form-control" id="postStatus" name="status" required>
                            <option value="published" <?php echo $post['status']=='published' ?'selected' :'';?>>Published</option>
                            <option value="draft" <?php echo $post['status']=='draft' ?'selected' :'';?>>Draft</option>
                        </select>
                    </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Post</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>


