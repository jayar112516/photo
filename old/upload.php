<?php
include 'db.php';

$caption = $_POST['caption'];
$photo = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];

$target = "uploads/" . basename($photo);
move_uploaded_file($tmp, $target);

$stmt = $conn->prepare("INSERT INTO photos (filename, caption) VALUES (?, ?)");
$stmt->bind_param("ss", $photo, $caption);
$stmt->execute();

header("Location: index.php");
?>
