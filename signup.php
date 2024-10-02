<?php
require 'session.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
   
    $encrypted_session_id = $_SESSION['user_id'];
    $decrypted_session_id = decryptSessionID($encrypted_session_id);
    
    if($encrypted_session_id){
        header("Location: dash.php");
    } 
    exit();
}

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
   require 'conn.php';

    // Get form values and sanitize them
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
    if(!empty($username)&&!empty($password) &&!empty($email)){
    // Insert user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $password);
    
    if ($stmt->execute()) {
        echo json_encode(['succees'=>true,'message'=>'Signup successfuly']);
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
else {
    echo json_encode(['succees'=>false,'message'=>'All fields arte requierd']);
}
}
