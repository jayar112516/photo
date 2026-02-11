<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    die("Access Denied");
}

$conn = new mysqli("localhost","root","","photobook");

/* TOTAL USERS */
$total = $conn->query("SELECT COUNT(*) as total FROM users");
$total_users = $total->fetch_assoc()['total'];

/* USER LIST */
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<h2>📊 Admin Dashboard</h2>

<h3>Total Users: <?php echo $total_users; ?></h3>

<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
</tr>

<?php while($u = $users->fetch_assoc()) { ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo $u['name']; ?></td>
<td><?php echo $u['email']; ?></td>
<td><?php echo $u['role']; ?></td>
</tr>
<?php } ?>

</table>
