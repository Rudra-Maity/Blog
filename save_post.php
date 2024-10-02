<?php
session_start();

require 'conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $tags = htmlspecialchars($_POST['tags']);
    
    $status = isset($_POST['publish']) ? 'published' : 'draft';
   if(!empty($title) && !empty($content) && !empty($status)){

    $user_id = $_SESSION['username']; 

    $sql = "INSERT INTO posts (user_id, title, content, tags, status) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issss', $user_id, $title, $content, $tags, $status);

    if ($stmt->execute()) {
        echo "Post saved successfully!";
        header("Location: index.php");  
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
else {
    echo json_encode(['success'=>false,'message'=>'content and title and published requierd']);
}

$conn->close();

}