<?php
include "admin_auth.php";
include "DB.php";

$notifications = [
    [
        "title" => "New Admission Form Submitted",
        "message" => "A new student admission form has been submitted and is pending for verification.",
        "time" => "10 Jan 2026, 11:30 AM",
        "type" => "info"
    ],
    [
        "title" => "Hostel Approval Required",
        "message" => "Student Parnika Mestri has requested hostel facility approval.",
        "time" => "09 Jan 2026, 4:15 PM",
        "type" => "alert"
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Notifications</title>

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


.topbar{
    height:60px;
    background:#3f6fa1;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 25px;
    font-size:15px;
    box-shadow:0 2px 6px rgba(0,0,0,0.12);
}


.container{
    display:flex;
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
    padding:30px;
    background:#fff;
    margin:20px;
    border-radius:10px;
    border:1px solid #dfe6ec;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}


.page-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
    color:#2c4e6e;
    border-bottom:2px solid #e3ebf2;
    padding-bottom:12px;
}


.notification{
    border:1px solid #d6e3ef;
    background:#fbfdff;
    padding:18px 22px;
    border-radius:8px;
    margin-bottom:18px;
    transition:transform 0.15s, box-shadow 0.15s;
}
.notification:hover{
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}


.notification.info{
    border-left:6px solid #3f6fa1;
}
.notification.alert{
    border-left:6px solid #d9534f;
}

.notification h4{
    margin:0 0 6px;
    color:#2c4e6e;
    font-size:16px;
}
.notification p{
    margin:0;
    color:#34495e;
    font-size:14px;
    line-height:1.5;
}
.notification .time{
    margin-top:10px;
    font-size:12px;
    color:#7f8c8d;
}


a{
    text-decoration:none;
}


@media print{
    .sidebar,.topbar{display:none;}
    .content{
        margin:0;
        box-shadow:none;
        border:none;
    }
}

</style>
</head>

<body>

<div class="topbar">
    <strong><?= $username ?></strong>
    <a href="login.php" style="color:#fff;text-decoration:none;">Sign Out</a>
</div>

<div class="container">

<div class="sidebar">
    <a href="Admin_Dash_StudentList.php">STUDENT</a>
    <a href="faculty.php">FACULTY</a>
    <a href="admin_notification.php" class="active">NOTIFICATIONS</a>
    <a href="admin_announcement.php">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php" >PROGRAM REGISTRATION</a>
</div>

<div class="content">

<div class="page-title">Admin Notifications</div>

<?php foreach($notifications as $n): ?>
<div class="notification <?= $n['type'] ?>">
    <h4><?= $n['title'] ?></h4>
    <p><?= $n['message'] ?></p>
    <div class="time"><?= $n['time'] ?></div>
</div>
<?php endforeach; ?>

</div>
</div>

</body>
</html>
