
<?php
include "DB.php";
include "admin_auth.php";
$query = "SELECT a.*, d.department_name 
          FROM announcements_admin a
          LEFT JOIN departments d ON a.dept_id = d.dept_id
          ORDER BY a.created_at DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Announcement Management</title>

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
    background:#fff;
    margin:25px;
    padding:30px;
    border-radius:10px;
    border:1px solid #dfe6ec;
    box-shadow:0 4px 14px rgba(0,0,0,0.06);
}

h2{
    margin-top:0;
    font-size:22px;
    color:#2c3e50;
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
    font-size:13px;
    transition:background 0.2s, transform 0.1s;
}
.btn:hover{
    background:#345f8c;
    transform:translateY(-1px);
}


.filters{
    background:#f8fafc;
    border:1px solid #dde6ec;
    padding:18px;
    margin-top:20px;
    border-radius:6px;
}
.filters label{
    display:inline-block;
    width:90px;
    font-weight:600;
    font-size:13px;
}
.filters select,
.filters input{
    padding:7px 8px;
    margin-right:15px;
    margin-bottom:10px;
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
th,td{
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


.priority-urgent{
    color:#d9534f;
    font-weight:600;
}
.priority-important{
    color:#f0ad4e;
    font-weight:600;
}
.priority-normal{
    color:#5cb85c;
    font-weight:600;
}

td:last-child{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
}

.action-btn{
    padding:6px 16px;
    border-radius:18px;
    border:none;
    cursor:pointer;
    color:#fff;
    font-size:12px;
    text-decoration:none;
    display:inline-block;
}

.view{
    background:#3f6fa1;
}
.view:hover{
    background:#345f8c;
}
.delete{
    background:#7f8c8d;
}
.delete:hover{
    background:#6c7a7b;
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
    <a href="admin_notification.php" >NOTIFICATIONS</a>
    <a href="admin_announcement.php" class="active">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION </a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php" >PROGRAM REGISTRATION</a>
</div>


<div class="content">

<h2>Announcement Management</h2>

<a href="create_announcement_admin.php" class="btn">
+ Create New Announcement
</a>

<div class="filters">
<b>Filters :</b><br><br>

<label>Audience</label>
<select id="audienceFilter" onchange="filterTable()">
<option value="all">All</option>
<option value="Students">Students</option>
<option value="Faculty">Faculty</option>
<option value="All">All Users</option>
</select>

<label>Dept</label>
<select id="deptFilter" onchange="filterTable()">
<option value="all">All</option>
<option value="Computer">Computer</option>
<option value="Mechanical">Mechanical</option>
<option value="Civil">Civil</option>
<option value="Electrical">Electrical</option>
</select>

<label>Priority</label>
<select id="priorityFilter" onchange="filterTable()">
<option value="all">All</option>
<option value="Urgent">Urgent</option>
<option value="Important">Important</option>
<option value="Normal">Normal</option>
</select>

<label>Search</label>
<input type="text" id="searchFilter" onkeyup="filterTable()">

</div>


<table id="announcementTable">
<tr>
<th>Date</th>
<th>Title</th>
<th>Audience</th>
<th>Department</th>
<th>Priority</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){

$priorityClass="";
if($row['priority']=="Urgent") $priorityClass="priority-urgent";
elseif($row['priority']=="Important") $priorityClass="priority-important";
else $priorityClass="priority-normal";
?>

<tr>
<td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['audience']; ?></td>
<td><?php echo $row['department_name'] ?? "All"; ?></td>
<td class="<?php echo $priorityClass; ?>">
<?php echo $row['priority']; ?>
</td>
<td><?php echo $row['status']; ?></td>
<td>
<a href="view_announcement_admin.php?id=<?php echo $row['announcement_id']; ?>" 
   class="action-btn view">View</a>

<a href="delete_announcement.php?id=<?php echo $row['announcement_id']; ?>" 
   class="action-btn delete"
   onclick="return confirm('Delete this announcement?');">
Delete
</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>


<script>
function filterTable(){
    let table=document.getElementById("announcementTable");
    let aud=document.getElementById("audienceFilter").value.toLowerCase();
    let dept=document.getElementById("deptFilter").value.toLowerCase();
    let pri=document.getElementById("priorityFilter").value.toLowerCase();
    let search=document.getElementById("searchFilter").value.toLowerCase();

    let rows=table.getElementsByTagName("tr");

    for(let i=1;i<rows.length;i++){
        let c=rows[i].getElementsByTagName("td");
        let show=true;

        if(aud!="all" && c[2].innerText.toLowerCase()!=aud) show=false;
        if(dept!="all" && c[3].innerText.toLowerCase()!=dept) show=false;
        if(pri!="all" && c[4].innerText.toLowerCase()!=pri) show=false;
        if(search && !c[1].innerText.toLowerCase().includes(search)) show=false;

        rows[i].style.display=show?"":"none";
    }
}
</script>

</body>
</html>
