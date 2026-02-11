<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "photobook");
if ($conn->connect_error) {
    die("Connection failed");
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// PREPARED STATEMENT (secure)
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // SAVE SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
		$_SESSION['role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];
		$_SESSION['profile_pic'] = $user['profile_pic'] ?? 'default.png'; 
		
        // REDIRECT
		
		
		
        header("Location: dashboard.php");
        exit();
    } else {
        echo "❌ Wrong password";
    }
} else {
    echo "❌ Account not found";
}
var_dump($user['password']);
echo "<br>";
var_dump($password);

$conn->close();
?>
<?php  ?>
