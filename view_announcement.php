<?php

include "DB.php";
include "faculty_auth.php";

if(!isset($_GET['id'])){
    header("Location: announcement.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT * FROM announcement_faculty 
    WHERE announcement_id=?
");

if(!$stmt){
    die("Prepare Failed: " . $conn->error);
}

$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Announcement Not Found";
    exit;
}

$a = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<title>Announcement Details</title>

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
    background:#fff;
    margin:25px;
    padding:35px;
    border-radius:10px;
    border:1px solid #dfe6ec;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}
.content h2{
    font-size:22px;
    border-bottom:2px solid #e6eef4;
    padding-bottom:10px;
}

.back-btn{
    background:#3f6fa1;
    color:white;
    padding:8px 22px;
    border-radius:25px;
    border:none;
    cursor:pointer;
    margin-bottom:25px;
    font-size:13px;
}

.label{
    font-weight:600;
    margin-top:18px;
    font-size:14px;
}

.box{
    border:1px solid #ccd6dd;
    padding:14px;
    border-radius:6px;
    margin-top:8px;
    background:#fafbfd;
    font-size:14px;
    line-height:1.6;
}

.actions{
    margin-top:35px;
    display:flex;
    justify-content:space-between;
}
.btn{
    padding:10px 28px;
    border-radius:25px;
    border:none;
    color:white;
    cursor:pointer;
    background:#3f6fa1;
    font-size:13px;
}
.btn:hover{background:#345f8c;}
.header-left{
            display:flex;
            align-items:center;
            gap:15px;
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
 <a href="announcement.php" class="active">ANNOUNCEMENTS</a>
</div>

<div class="content">

<h2>Announcement Details</h2>

<button class="back-btn"
onclick="window.location.href='announcement.php'">
← Back To Announcements
</button>

<div class="label">Title :</div>
<div><?php echo htmlspecialchars($a['title']); ?></div>

<div class="label">Category :</div>
<div><?php echo htmlspecialchars($a['category']); ?></div>

<div class="label">Posted On :</div>
<div><?php echo date("d M Y, h:i A", strtotime($a['created_at'])); ?></div>

<div class="label">Message :</div>
<div class="box">
<?php echo nl2br(htmlspecialchars($a['message'])); ?>
</div>

<div class="label">Attachment :</div>
<?php if(!empty($a['file_path'])){ ?>
<a href="<?php echo $a['file_path']; ?>" class="btn" download>
Download File
</a>
<?php } else { ?>
<div style="color:#777;font-size:13px;margin-top:8px;">No Attachment</div>
<?php } ?>

<div class="actions">
<button class="btn" onclick="window.location.href='edit_announcement.php?id=<?php echo $a['announcement_id']; ?>'">
        Edit Announcement
    </button>

<button class="btn"
onclick="if(confirm('Delete this announcement?'))
window.location.href='delete_announcement.php?id=<?php echo $a['announcement_id']; ?>'">
Delete
</button>
</div>

</div>
</div>

</body>
</html>