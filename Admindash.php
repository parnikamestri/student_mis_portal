<?php
include "admin_auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

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


.content {
    flex: 1;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.content img {
    width: 92%;
    height: 92%;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 0 12px rgba(0,0,0,0.2);
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
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
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
        <a href="create_profile_office_staff.php">OFFICE STAFF REGISTRATION</a>
        <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
        <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
        <a href="program_registration.php">PROGRAM REGISTRATION</a>
    </div>

  
    <div class="content">
        <img src="https://content3.jdmagicbox.com/comp/ratnagiri/d1/9999p2352.2352.181113155857.v3d1/catalogue/government-polytechnic-abhyudhya-nagar-ratnagiri-colleges-lJLf5AnjcD.jpg">
    </div>

</div>

</body>
</html>