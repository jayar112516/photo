<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>My PhotoBook</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>📸 My PhotoBook</h2>

<form action="upload.php" method="POST" enctype="multipart/form-data">
  <input type="file" name="photo" required>
  <input type="text" name="caption" placeholder="Write a caption..." required>
  <button type="submit">Upload</button>
</form>

<hr>

<div class="feed">
<?php
$result = $conn->query("SELECT * FROM photos ORDER BY created_at DESC");
while($row = $result->fetch_assoc()):
?>
  <div class="post">
    <img src="uploads/<?php echo $row['filename']; ?>">
    <p><?php echo htmlspecialchars($row['caption']); ?></p>
    <small><?php echo $row['created_at']; ?></small>
  </div>
<?php endwhile; ?>
</div>

</body>
</html>
