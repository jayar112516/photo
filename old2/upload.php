<?php
include 'includes/db.php';
include 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $img = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file($tmp, "uploads/$img");

    $conn->query("INSERT INTO photos (filename) VALUES ('$img')");
    header("Location: index.php");
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
<form method="POST" enctype="multipart/form-data">
  <input type="file" name="photo" class="form-control mb-3" required>
  <button class="btn btn-primary">Upload</button>
</form>
</div>
