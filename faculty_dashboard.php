<?php
include("faculty_auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Profile | Student MIS</title>


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
    font-family: "Segoe UI", Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}



.header{
    height:70px;
    background:linear-gradient(135deg,#5f84a9,#4f6d8a);
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.header-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.profile-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    background:white;
    color:#5f84a9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:bold;
}

.header-title{
    font-size:22px;
    font-weight:600;
    letter-spacing:0.5px;
}



.container{
    display:flex;
    height:calc(100vh - 70px);
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
    transition:all 0.25s ease;
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
    padding:25px;
    background:#f8f9fa;
    display:flex;
    align-items:center;
    justify-content:center;
}

.image-card{
    width:92%;
    height:92%;
    border-radius:8px;
    overflow:hidden;
    background:white;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

.content img {
    width: 98%;
    height: 98%;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 0 12px rgba(0,0,0,0.2);
}
.image-card img{
    width:100%;
    height:100%;
    object-fit:cover;
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
        <div class="header-title"><?php echo $name; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>


<div class="container">


    <div class="sidebar">
        <a href="faculty_attendance_select.php">ATTENDANCE</a>
        <a href="marks_entry.php">MARKS ENTRY</a>
        <a href="reports.php">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMENTS</a>
    </div>

  
    <div class="content">
        <img src="https://content3.jdmagicbox.com/comp/ratnagiri/d1/9999p2352.2352.181113155857.v3d1/catalogue/government-polytechnic-abhyudhya-nagar-ratnagiri-colleges-lJLf5AnjcD.jpg">
    </div>

</div>

</body>
</html>
