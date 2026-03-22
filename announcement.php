
<?php
include "DB.php";
include "faculty_auth.php";

$stmt = $conn->prepare("
    SELECT announcement_id, title, category, created_at 
    FROM announcement_faculty
    WHERE faculty_id = ?
    ORDER BY created_at DESC
");

if(!$stmt){
    die("Prepare Failed: " . $conn->error);
}

$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Announcements</title>

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
    padding:30px;
    border-radius:10px;
    border:1px solid #dfe6ec;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}
.content h2{
    margin-top:0;
    font-size:22px;
    border-bottom:2px solid #e6eef4;
    padding-bottom:10px;
}


.btn{
    background:#3f6fa1;
    color:white;
    padding:10px 22px;
    border-radius:25px;
    text-decoration:none;
    border:none;
    cursor:pointer;
    display:inline-block;
    font-size:13px;
    transition:background 0.2s, transform 0.1s;
}
.btn:hover{
    background:#345f8c;
    transform:translateY(-1px);
}


.filters{
    margin-top:20px;
    background:#f8fafc;
    padding:15px;
    border-radius:6px;
    border:1px solid #dde6ec;
}
.filters label{
    display:inline-block;
    width:90px;
    font-weight:600;
    font-size:13px;
}
.filters select,
.filters input{
    margin-bottom:10px;
    padding:6px 8px;
    border:1px solid #cfd8df;
    border-radius:4px;
    font-size:13px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    font-size:14px;
}
th, td{
    border:1px solid #d6dde3;
    padding:12px;
    text-align:center;
}
th{
    background:#f1f5f9;
    font-weight:600;
}
tr:hover td{
    background:#f8fbfd;
}

.action-btn{
    background:#3f6fa1;
    color:white;
    padding:6px 16px;
    border-radius:18px;
    text-decoration:none;
    border:none;
    cursor:pointer;
    font-size:12px;
    margin:0 3px;
}
.action-btn:hover{
    background:#345f8c;
}

.delete{
    background:#7f8c8d;
}
.delete:hover{
    background:#6c7a7b;
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
 .header-left{
            display:flex;
            align-items:center;
            gap:15px;
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

<h2>Announcements</h2>

<a href="create_announcement.php" class="btn">
+ Create New Announcement
</a>

<table>
<tr>
<th>Date</th>
<th>Title</th>
<th>Category</th>
<th>Action</th>
</tr>

<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
?>
<tr>
<td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
<td><?php echo htmlspecialchars($row['title']); ?></td>
<td><?php echo $row['category']; ?></td>
<td>
<a href="view_announcement.php?id=<?php echo $row['announcement_id']; ?>" class="btn">View</a>
<a href="delete_announcement.php?id=<?php echo $row['announcement_id']; ?>" 
   class="btn delete"
   onclick="return confirm('Delete this announcement?')">
Delete</a>
</td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='4'>No Announcements Found</td></tr>";
}
?>

</table>

</div>
</div>
</body>
</html>