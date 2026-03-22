<?php

include "DB.php";
include "faculty_auth.php";

$facultyName = $_SESSION['faculty_name'] ?? 'Faculty';
$facultyDept = $_SESSION['dept_id'] ?? 0;

$sql = "
SELECT *
FROM announcements_admin
WHERE status='Active'
AND (audience IN ('Faculty','HOD','Office_worker','All'))
AND (dept_id='$facultyDept' OR dept_id=1)
ORDER BY created_at DESC
";

$res = mysqli_query($conn, $sql);
if(!$res){
    die("Query Error : ".mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Faculty Dashboard - Notifications</title>

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

/* ===== HEADER ===== */

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
    padding:40px;
    min-width:300px;
    display:flex;
    justify-content:center;
    align-items:center;
}
.main{flex:1;padding:30px;background:#fff;}
.page-title{font-size:20px;margin-bottom:20px}


@keyframes fadeSlide{
    from{opacity:0;transform:translateY(10px);}
    to{opacity:1;transform:translateY(0);}
}


.notification{
    border:1px solid #ddd;
    border-left:6px solid #ccc;
    border-radius:12px;
    padding:18px;
    margin-bottom:15px;
    max-width:650px;
    cursor:pointer;
    animation:fadeSlide .4s ease;
    transition:.2s;
    box-shadow:0 2px 6px rgba(0,0,0,.05);
}
.notification:hover{
    box-shadow:0 6px 18px rgba(0,0,0,.12);
    transform:translateY(-2px);
}


.notification.normal{border-left-color:#6c757d;}
.notification.important{border-left-color:#1b5fd1;}
.notification.urgent{border-left-color:#d60000;}


.notification.expired{
    opacity:.5;
    background:#f2f2f2;
    border-left-color:#999;
}


.badge{
    display:inline-block;
    padding:3px 12px;
    font-size:11px;
    border-radius:20px;
    color:#fff;
    margin-bottom:6px;
}
.badge.normal{background:#6c757d;}
.badge.important{background:#1b5fd1;}
.badge.urgent{background:#d60000;}
.badge.expired{background:#888;}

.notification h4{margin-bottom:6px;font-size:15px}
.notification p{font-size:14px;color:#555}

.notif-meta{
    margin-top:6px;
    font-size:12px;
    color:#777;
}


#notifModal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
}
.modal-box{
    background:#fff;
    width:520px;
    margin:10% auto;
    padding:22px;
    border-radius:14px;
    animation:fadeSlide .3s ease;
}
.modal-box h3{margin-bottom:10px}
.modal-box button{
    background:#2e5aac;color:#fff;
    padding:6px 18px;
    border:none;border-radius:20px;
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
        <a href="notifications.php" class="active">NOTIFICATIONS</a>
        <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php" >ANNOUNCEMENT</a>
    </div>


<div class="main">
<div class="page-title">Notifications</div>

<?php
if(mysqli_num_rows($res)>0){
    while($row=mysqli_fetch_assoc($res)){

        $expired  = (strtotime($row['expiry_date']) < time());
        $priority = strtolower($row['priority']);
        $class    = $expired ? "expired" : $priority;
?>
<div class="notification <?php echo $class; ?>"
     onclick="openModal('<?php echo addslashes($row['title']); ?>',
                        '<?php echo addslashes($row['message']); ?>')">

    <span class="badge <?php echo $class; ?>">
        <?php echo strtoupper($expired ? "EXPIRED" : $priority); ?>
    </span>

    <h4><?php echo $row['title']; ?></h4>

    <p><?php echo substr($row['message'],0,90); ?>...</p>

    <div class="notif-meta">
        📅 <?php echo date("d M Y", strtotime($row['created_at'])); ?>
        <?php if($expired){ ?>
            | ⛔ Expired on <?php echo date("d M Y", strtotime($row['expiry_date'])); ?>
        <?php } ?>
    </div>
</div>
<?php } } else { ?>
<p>No notifications available.</p>
<?php } ?>

</div>
</div>

<div id="notifModal">
    <div class="modal-box">
        <h3 id="modalTitle"></h3>
        <p id="modalMsg"></p><br>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script>
function openModal(title,msg){
    document.getElementById("modalTitle").innerText = title;
    document.getElementById("modalMsg").innerText = msg;
    document.getElementById("notifModal").style.display = "block";
}
function closeModal(){
    document.getElementById("notifModal").style.display = "none";
}
</script>

</body>
</html>