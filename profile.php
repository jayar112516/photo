<?php
session_start();

// PROTECT PAGE
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "photobook");
if ($conn->connect_error) {
    die("Connection failed");
}

// GET USER DATA
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Photobook | Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background: #fff;
            width: 400px;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #667eea;
            color: #fff;
            font-size: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        h2 { margin: 10px 0; }
        p { color: #555; }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="avatar">
        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
    </div>

    <h2><?php echo htmlspecialchars($user['full_name']); ?></h2>
    <p><?php echo htmlspecialchars($user['email']); ?></p>
    <p>Member since: <?php echo date("F d, Y", strtotime($user['created_at'])); ?></p>

    <a href="dashboard.php">⬅ Back to Dashboard</a><br>
	 <?php if($_SESSION['role']=="admin"){ ?>
        <a href="admin.php">Admin Panel</a>
    <?php } ?>
    <a href="logout.php">🚪 Logout</a>
</div>

</body>
</html>
