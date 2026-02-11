<?php
include 'includes/db.php';

if ($_POST) {
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (email,password) VALUES ('$email','$pass')");
    header("Location: login.php");
}
?>

<form method="POST" class="container mt-5">
  <input name="email" class="form-control mb-2" placeholder="Email">
  <input type="password" name="password" class="form-control mb-2">
  <button class="btn btn-success w-100">Register</button>
</form>
