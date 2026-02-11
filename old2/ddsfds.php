<?php
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/header.php';

$result = $conn->query("
SELECT photos.id, photos.filename 
FROM photos 
ORDER BY photos.created_at DESC
");
?>

<div class="container mt-4">
  <div class="row">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="col-md-3 mb-3">
        <img src="uploads/<?php echo $row['filename']; ?>"
             class="img-fluid rounded shadow-sm">
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
