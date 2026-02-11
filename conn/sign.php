<?php
$conn = new mysqli("localhost", "root", "", "photobook_db");

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
