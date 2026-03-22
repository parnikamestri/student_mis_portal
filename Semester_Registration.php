<?php
include "admin_auth.php";
include "DB.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Semester Registration</title>

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
    background:#ffffff;
    display:flex;
    justify-content:center;
    align-items:center;
}

.dept-card{
    width:500px;
    padding:35px;
    border-radius:8px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    background:#fff;
}

.dept-card h2{
    text-align:center;
    margin-bottom:30px;
    color:var(--primary-dark);
}

.form-group{
    margin-bottom:18px;
    display:flex;
    align-items:center;
}

.form-group label{
    width:160px;
    font-weight:600;
}

.form-group input,
.form-group select{
    width:220px;
    padding:7px 10px;
    border:1px solid #aaa;
    border-radius:4px;
    outline:none;
}

.form-group input:focus,
.form-group select:focus{
    border-color:var(--primary);
}

.year-text{
    font-weight:bold;
    color:var(--primary-dark);
}

.btn-submit{
    display:block;
    margin:20px auto 0;
    padding:10px 35px;
    background:#5b7fa6;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.btn-submit:hover{
    background:#3d5a73;
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
    background: linear-gradient(135deg, #e53935, #c62828);
    color:white;
    padding:8px 16px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition: all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg, #c62828, #b71c1c);
    transform: translateY(-2px);
} 
</style>
</head>

<body>

<div class="header">
    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $username; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>

<div class="main">

<div class="sidebar">
    <a href="Admin_Dash_StudentList.php">STUDENT</a>
    <a href="faculty.php">FACULTY</a>
    
    <a href="admin_notification.php">NOTIFICATIONS</a>
    <a href="admin_announcement.php">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php" class="active">SEMESTER REGISTRATION</a>
    <a href="program_registration.php">PROGRAM REGISTRATION</a>
</div>

<div class="content">
<div class="dept-card">
<h2>Semester Registration</h2>

<form method="POST" action="save_semester.php">

<div class="form-group">
<label>Program :</label>
<select name="program_id" required>
<option value="">Select</option>
<?php
$query = "SELECT * FROM program WHERE status='Active'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
?>
<option value="<?php echo $row['program_id']; ?>">
<?php echo $row['program_name']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Semester Name :</label>
<input type="text" name="semester_name" required>
</div>

<div class="form-group">
<label>Semester Number :</label>
<input type="text" name="semester_number" required>
</div>

<div class="form-group">
<label>Academic Year :</label>
<span class="year-text" id="academicYear"></span>
<input type="hidden" name="academic_year" id="academicYearInput">
</div>

<button type="submit" class="btn-submit">Register</button>

</form>
</div>
</div>
</div>

<script>
const today = new Date();
const year = today.getFullYear();
const month = today.getMonth() + 1;

let academicYear = "";

if (month <= 6) {
    academicYear = (year - 1) + "-" + year.toString().slice(-2);
} else {
    academicYear = year + "-" + (year + 1).toString().slice(-2);
}

document.getElementById("academicYear").innerText = academicYear;
document.getElementById("academicYearInput").value = academicYear;
</script>

</body>
</html>
