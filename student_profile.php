<?php
$roll = $_GET['roll'] ?? 'Unknown';
?>
<!DOCTYPE html>
<html>
<head><title>Student Profile</title>
<style>
:root{
    --primary:#4f6d8a;
    --primary-dark:#3d5a73;
    --accent:#5aa6c8;
    --bg:#f4f7f9;
    --card:#ffffff;
    --border:#d6e2ea;
    --text:#2c3e50;
    --muted:#6b7c8f;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}
.box{max-width:500px;margin:80px auto;background:#fff;padding:25px;border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,.15)}
</style>
</head>
<body>
<div class="box">
<h2>Student Profile</h2>
<p><b>Roll Number:</b> <?= $roll ?></p>
<p>More student details can be added here.</p>
<a href="class_students.php">⬅ Back to List</a>
</div>
</body>
</html>