<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Form for Creating or Editing Blog Post -->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="POST" action="save_post.php">
        <!-- Title Input -->
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Enter your title" required>
        </div>

        <!-- Rich Text Editor (TinyMCE) -->
        <div class="mb-3">
          <label for="editor" class="form-label">Content</label>
          <textarea id="editor" name="content"></textarea>
        </div>

        <!-- Tags Input -->
        <div class="mb-3">
          <label for="tags" class="form-label">Tags (Optional)</label>
          <input type="text" class="form-control" id="tags" name="tags" placeholder="Add tags separated by commas">
        </div>

        <!-- Buttons for Publish and Save as Draft -->
        <div class="d-flex justify-content-between">
          <button type="submit" name="publish" class="btn btn-primary">Publish</button>
          <button type="submit" name="draft" class="btn btn-secondary">Save as Draft</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- TinyMCE Script -->
<script src="https://cdn.tiny.cloud/1/smbwxu6548zypvpht8agryyawkn6gte7eve6kogrzhqd6sdh/tinymce/5/tinymce.min.js"></script>
<script>
  tinymce.init({ 
    selector: '#editor', 
    height: 300,  // Define a height for the editor
    plugins: 'link image code', 
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | code',
    // menubar: false, 
    content_css: '//www.tiny.cloud/css/codepen.min.css'  
  });
</script>

<!-- Bootstrap JS and Dependencies (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
