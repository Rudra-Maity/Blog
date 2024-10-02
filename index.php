<?php
session_start();
require 'conn.php';

// Fetch posts
$sql = "SELECT * FROM posts ";
$stmt = $conn->prepare($sql);
// $stmt->bind_param();
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="dash.php">Dashboard <span class="sr-only">(current)</span></a>
      </li>
       <?php if(!isset( $_SESSION['username'])): ?> 
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="auth/signup.php">Signup</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="auth/login.php">Login</a>
      </li>
     <?php else :?>
        <li class="nav-item">
        <a class="nav-link" href="auth/logout.php">Logout</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<div class="container mt-5">
  
<input type="text" id="searchBar" class="form-control w-50" placeholder="Search by title...">
    <div class="row mt-3" id="postsContainer">
        <!-- Posts will be shown here as cards -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text">Status: <?php echo htmlspecialchars($row['status']); ?></p>
                            <div class="card-text">Content: <?php echo (html_entity_decode($row['content'])); ?></div>

                            <p class="card-text">Created at: <?php echo htmlspecialchars($row['created_at']); ?></p>
                           
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>


<!-- Bootstrap JS & FontAwesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  
</script>
<script>
// Live Search
$('#searchBar').on('keyup', function () {
    let query = $(this).val().toLowerCase();
    $('#postsContainer .col-md-4').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
    });
});



</script>
</body>
</html>
