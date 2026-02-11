<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "photobook");
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Photobook | Dashboard</title>
	
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 18px;
        }
        form {
            margin-bottom: 30px;
        }
        input, textarea, button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
        }
        button {
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        /* PHOTO ALBUM GRID */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        .photo-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
        }
        .photo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }
        .photo-card:hover img {
            transform: scale(1.1);
        }
        .caption {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.6);
            color: #fff;
            padding: 10px;
            font-size: 13px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .photo-card:hover .caption {
            opacity: 1;
        }
        .top-links {
            text-align: center;
            margin-top: 20px;
        }
        .top-links a {
            margin: 0 10px;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
        }
		.fb-profile {
    text-align: center;
    margin-bottom: 30px;
}

.profile-wrapper {
    position: relative;
    width: 130px;
    height: 130px;
    margin: auto;
}

.profile-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

/* CAMERA BUTTON STYLE */
.camera-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    background: #1877f2;
    color: #fff;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-size: 18px;
}

/* FACEBOOK STYLE BUTTON */
.fb-btn {
    margin-top: 15px;
    background: #1877f2;
    border: none;
    color: white;
    padding: 8px 18px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    width: auto;          /* eto ang importante */
    display: inline-block;
}

.fb-btn:hover {
    background: #166fe5;
}

.upload-btn {
    width: auto;
    padding: 10px 18px;
    background: #667eea;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: inline-block;
}
.upload-btn {
    background: #1877f2;
    font-weight: bold;
}
.profile-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 10px;
}

.profile-actions a {
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.profile-link {
    background: #e4efff;
    color: #1877f2;
}

.logout-link {
    background: #ffe5e5;
    color: #d11a2a;
}

    </style>
</head>
<body>



<div class="card">
<!-- PROFILE PICTURE UPLOAD -->
<div class="fb-profile">

    <div class="profile-wrapper">
        <img src="uploads/profiles/<?php echo htmlspecialchars($_SESSION['profile_pic'] ?? 'default.png'); ?>" 
             class="profile-img">

        <label for="profileUpload" class="camera-btn">📷</label>
    </div>

    <div class="profile-actions">
        <a href="profile.php" class="profile-link">👤 Profile</a>
        <a href="logout.php" class="logout-link">🚪 Logout</a>
    </div>

    <form action="upload_profile.php" method="POST" enctype="multipart/form-data">
        <input type="file" id="profileUpload" name="profile_pic" accept="image/*" required hidden>
        <button type="submit" class="fb-btn">Save Profile Picture</button>
    </form>

</div>
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?> 📘</h2>

    <!-- UPLOAD -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="photos[]" multiple required>
        <textarea name="caption" placeholder="Write a caption..."></textarea>
        <button type="submit" class="upload-btn">Upload to Album</button>
    </form>

    <hr>

    <!-- PHOTO ALBUM -->
    <div class="gallery">
        <?php
        $sql = "SELECT * FROM photos WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

       while ($row = $result->fetch_assoc()) {
    echo '
    <div class="photo-card">
        <img src="uploads/'.$row['photo'].'">
        <div class="caption">
            <small>'.date("F d, Y", strtotime($row['created_at'])).'</small><br>
            '.htmlspecialchars($row['caption']).'
        </div>
    </div>';
}

        ?>
    </div>

    <?php if($_SESSION['role']=="admin"){ ?>
<a href="admin.php">Admin Panel</a>
<?php } ?>
</div>

</body>
</html>
