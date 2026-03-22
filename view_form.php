<?php
include 'office_auth.php';
include 'DB.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Office Dashboard</title>

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


.header {
    height: 70px;
    background-color: #5b7fa6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    color: #5b7fa6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.header-title {
    font-size: 22px;
    font-weight: bold;
}

.logout a{
    color:white;
    text-decoration:none;
    font-size:16px;
}


.main {
    display: flex;
    height: calc(100vh - 70px);
}

.sidebar{
    width:260px;
    background:#eef3f7;
    border-right:1px solid var(--border);
}
.sidebar a{
    display:block;
    padding:18px 22px;
    border-bottom:1px solid #dbe6ed;
    text-decoration:none;
    color:var(--text);
    font-size:14px;
    font-weight:600;
    transition:0.25s;
}
.sidebar a:hover{
    background:#dde8f0;
    padding-left:28px;
}
.sidebar a.active{
    background:#dde8f0;
    border-left:4px solid var(--primary);
}

.content{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* DEPARTMENT BOX */

.department-box{
    background:white;
    padding:20px 30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    display:flex;
    gap:15px;
    align-items:center;
}

.department-box label{
    font-weight:600;
}

.department-box select{
    padding:8px 15px;
    border-radius:20px;
    border:1px solid #ccc;
}

/* BUTTON */

.next-btn{
    background:linear-gradient(135deg,#5e82a8,#4b6f94);
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:25px;
    cursor:pointer;
    font-weight:600;
}

.next-btn:hover{
    transform:translateY(-2px);
}
.logout{
    color:white;
    text-decoration:none;
    font-size:15px;
}

.logout:hover{
    opacity:0.8;
}
.logout-btn{
    display:inline-block;
    background: linear-gradient(135deg,#e53935,#c62828);
    color:white;
    padding:8px 18px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition:all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg,#c62828,#b71c1c);
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.25);
}

</style>
</head>

<body>

<div class="header">

    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title">
            <?php echo $username; ?>
        </div>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>

</div>


<div class="main">


<div class="sidebar">

<a href="view_form.php" class="active">
VIEW FORM
</a>

</div>



<div class="content">

<form method="post" action="view_student_application.php" class="department-box">

<label>Select Department</label>

<select name="department_id" required>

<option value="">-- Select --</option>

<?php

$query = mysqli_query($conn,"SELECT * FROM departments WHERE status=1");

while($dept = mysqli_fetch_assoc($query)){

?>

<option value="<?php echo $dept['dept_id']; ?>">
<?php echo strtoupper($dept['department_name']); ?>
</option>

<?php } ?>

</select>

<button type="submit" class="next-btn">Next</button>

</form>

</div>

</div>

</body>
</html>