<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    }
}
?>

<form method="POST" class="container mt-5">
  <input name="email" class="form-control mb-2" placeholder="Email">
  <input type="password" name="password" class="form-control mb-2">
  <button class="btn btn-dark w-100">Login</button>
</form>
