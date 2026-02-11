<?php
$conn = new mysqli("localhost", "root", "", "photobook");

if ($conn->connect_error) {
    die("Connection failed");
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (full_name, email, password)
        VALUES ('$fullname', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Sign up successful!";
	
} else {
    echo "Email already exists!";
}

$conn->close();

?>

 <div class="extra">
      <a href="index.php"><b>Back to log in</b></a>
    </div>