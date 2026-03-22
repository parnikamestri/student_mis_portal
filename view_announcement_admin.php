<?php
include "DB.php";

$id = $_GET['id'];

$query = "SELECT a.*, d.department_name 
          FROM announcements_admin a
          LEFT JOIN departments d ON a.dept_id = d.dept_id
          WHERE a.announcement_id='$id'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>View Announcement</title>
<style>
body{ font-family:Arial; padding:30px; background:#f4f6f9; }
.card{
    background:white;
    padding:20px;
    border-radius:6px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
h3{ margin-bottom:10px; }
</style>
</head>
<body>

<div class="card">
<h3><?php echo $row['title']; ?></h3>

<p><strong>Date:</strong> <?php echo date("Y-m-d", strtotime($row['created_at'])); ?></p>

<p><strong>Audience:</strong> <?php echo $row['audience']; ?></p>

<p><strong>Department:</strong> <?php echo $row['department_name'] ?? "All"; ?></p>

<p><strong>Priority:</strong> <?php echo $row['priority']; ?></p>

<p><strong>Status:</strong> <?php echo $row['status']; ?></p>

<hr>

</div>

</body>
</html>
