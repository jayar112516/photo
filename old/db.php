<?php
$conn = new mysqli("localhost", "root", "", "photobook");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
