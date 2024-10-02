<?php
require 'session.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require 'conn.php';

// Decrypt session ID
$encrypted_session_id = $_SESSION['user_id'];
$decrypted_session_id = decryptSessionID($encrypted_session_id);

// Fetch posts for the logged-in user
$username = $_SESSION['username'];
$sql = "SELECT * FROM posts WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/smbwxu6548zypvpht8agryyawkn6gte7eve6kogrzhqd6sdh/tinymce/5/tinymce.min.js"></script>
</head>

<body>

<div class="container mt-5">
    <a href="/Blog" class="btn btn-primary" >Home</a>
    <?php if ($decrypted_session_id === session_id()): ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPostModal">Create New Post</button>
                    <a href="auth/logout.php" class="btn btn-danger">Logout</a>
                </div>
                <!-- Search Bar -->
                <input type="text" id="searchBar" class="form-control w-50" placeholder="Search by title...">
            </div>
        </div>
    </div>

    <div class="row mt-3" id="postsContainer">
        <!-- Posts displayed here as cards -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text">Status: <?php echo htmlspecialchars($row['status']); ?></p>
                            <div class="card-text">Content: <?php echo (html_entity_decode($row['content'])); ?></div>

                            <p class="card-text">Created at: <?php echo htmlspecialchars($row['created_at']); ?></p>
                            <div class="d-flex justify-content-between">
                                <!-- Edit Button -->
                                <button class="btn btn-secondary" onclick="openEditModal(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <!-- Delete Button -->
                                <button class="btn btn-danger" onclick="deletePost(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have not created any posts yet.</p>
        <?php endif; ?>
    </div>
    <?php else:
        echo "Session is invalid. Please log in again.";
        session_destroy();
        header("Location: login.php");
        exit();
    ?>
    <?php endif; ?>
</div>

<!-- Add Post Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostLabel">Create New Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPostForm">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editor2" class="form-label">Content</label>
                        <textarea id="editor2" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (Optional)</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Add tags separated by commas">
                    </div>
                    <div class="mb-3">
                        <label for="postStatus" class="form-label">Status</label>
                        <select class="form-control" id="postStatus" name="status" required>
                            <option value="Published">Published</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostLabel">Edit Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editPostModalContent">
                <!-- Form content for editing a post will be fetched here -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS & FontAwesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- TinyMCE -->
<script>
tinymce.init({ 
    selector: '#editor2', 
    height: 300,
    plugins: 'link image code',
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | code',
    content_css: '//www.tiny.cloud/css/codepen.min.css'  
});

// Live Search functionality
$('#searchBar').on('keyup', function () {
    let query = $(this).val().toLowerCase();
    $('#postsContainer .col-md-4').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
    });
});

// Open edit modal with fetched content
function openEditModal(id) {
    $.ajax({
        url: 'edit_post.php',
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#editPostModalContent').html(response);
            $('#editPostModal').modal('show');
        },
        error: function () {
            alert('Error fetching post data.');
        }
    });
}

// Delete post function
function deletePost(id) {
    if (confirm('Are you sure you want to delete this post?')) {
        $.ajax({
            url: 'delete_post.php?id='+id,
            type: 'DELETE',
            dataType:"json",
            // data: { id: id },
            success: function (response) {
                console.log(response);
                
                if (response.success) {
                    alert('Post deleted successfully');
                    location.reload();
                } else {
                    alert('Error deleting post.');
                }
            }
        });
    }
}

// Handle add post form submission
$('#addPostForm').on('submit', function (e) {
    e.preventDefault();
    
    $('#editor2').val(tinymce.get('editor2').getContent());
    
    $.ajax({
        url: 'save_post.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            $('#addPostModal').modal('hide');
            location.reload();
        },
        error: function () {
            alert('Error saving post.');
        }
    });
});

// TinyMCE re-initialize on opening the add post modal
$('#addPostModal').on('show.bs.modal', function () {
    tinymce.init({ 
        selector: '#editor2', 
        height: 300,
        plugins: 'link image code', 
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | code',
        content_css: '//www.tiny.cloud/css/codepen.min.css' 
    });
});

</script>
</body>
</html>
