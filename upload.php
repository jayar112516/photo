<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "photobook");
if ($conn->connect_error) {
    die("DB connection failed");
}

$user_id = $_SESSION['user_id'];
$caption = $_POST['caption'];

$files = $_FILES['photos'];
$total = count($files['name']);

$sql = "INSERT INTO photos (user_id, photo, caption) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

for ($i = 0; $i < $total; $i++) {

    if ($files['error'][$i] === 0) {

        $photoName = time() . "_" . $files['name'][$i];
        $target = "uploads/" . $photoName;

        if (move_uploaded_file($files['tmp_name'][$i], $target)) {
            $stmt->bind_param("iss", $user_id, $photoName, $caption);
            $stmt->execute();
        }
    }
}

header("Location: dashboard.php");
exit();
?>
