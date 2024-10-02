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
// require 'session.php';
// session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require "conn.php";
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];
if(!empty($username) && !empty($password)){
    // Get form values and sanitize them

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Encrypt the session ID and store it in the session
        $session_id = session_id();
        $encrypted_session_id = encryptSessionID($session_id);
        
        // Store encrypted session ID and user info in the session
       
        $_SESSION['user_id'] = $encrypted_session_id;
        $_SESSION['username'] = $user['id'];
        echo json_encode(['succees'=>true,'message'=>'Logged in successfully']);
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
else {
    echo json_encode(['succees'=>false,'message'=>'all fields are requierd']);
}
}
