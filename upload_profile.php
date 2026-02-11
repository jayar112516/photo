<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "photobook");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        die("Invalid file type.");
    }

    if ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
        die("File too large. Max 2MB.");
    }

    $new_name = 'profile_'.$user_id.'_'.time().'.'.$ext;
    $target = 'uploads/profiles/'.$new_name;

    if (!is_dir('uploads/profiles')) {
        mkdir('uploads/profiles', 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $target)) {
        // Update in DB
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $new_name, $user_id);
        $stmt->execute();
        $_SESSION['profile_pic'] = $new_name;

        header("Location: dashboard.php");
        exit();
    } else {
        die("Failed to upload file.");
    }
}
?>
