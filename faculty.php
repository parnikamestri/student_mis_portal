<?php
include "admin_auth.php";
include "DB.php";

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

$dept   = $_GET['dept']   ?? '';
$view   = $_GET['view']   ?? '';
$delete = $_GET['delete'] ?? '';


if($delete != ''){
    $delete = mysqli_real_escape_string($conn,$delete);

    $delQuery = "UPDATE faculty SET status='Inactive' WHERE emp_no='$delete'";
    if(!mysqli_query($conn,$delQuery)){
        die("Delete Error: ".mysqli_error($conn));
    }

    header("Location: faculty.php?dept=$dept");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Profile</title>
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
    padding:40px;
}

table{
    width:80%;
    border-collapse:collapse;
    margin-top:25px;
    background:#fff;
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

th,td{
    border:1px solid #e2e8ee;
    padding:12px;
    text-align:center;
    font-size:14px;
}

th{
    background:#f1f5f9;
    font-weight:600;
}

tr:nth-child(even){
    background:#fafbfd;
}

tr:hover{
    background:#f5f9fc;
}

.view-btn{
    background:#5aa6c8;
    color:#fff;
    border:none;
    padding:7px 16px;
    border-radius:20px;
    cursor:pointer;
    font-size:13px;
    transition:0.25s;
}

.view-btn:hover{
    background:#4b95b6;
}

.delete-btn{
    background:linear-gradient(135deg,#e74c3c,#c0392b);
    color:#fff;
    border:none;
    padding:9px 22px;
    border-radius:25px;
    cursor:pointer;
    font-size:14px;
    font-weight:500;
    transition:all 0.25s ease;
    box-shadow:0 3px 8px rgba(0,0,0,0.12);
}

.delete-btn:hover{
    background:linear-gradient(135deg,#c0392b,#a93226);
    transform:translateY(-2px);
    box-shadow:0 5px 12px rgba(0,0,0,0.2);
}

.delete-btn:active{
    transform:scale(0.97);
}

.back-btn{
    background:linear-gradient(135deg,#95a5a6,#7f8c8d);
    color:#fff;
    border:none;
    padding:9px 22px;
    border-radius:25px;
    margin-left:10px;
    cursor:pointer;
    font-size:14px;
    font-weight:500;
    transition:all 0.25s ease;
    box-shadow:0 3px 8px rgba(0,0,0,0.12);
}

.back-btn:hover{
    background:linear-gradient(135deg,#7f8c8d,#636e72);
    transform:translateY(-2px);
    box-shadow:0 5px 12px rgba(0,0,0,0.2);
}

.back-btn:active{
    transform:scale(0.97);
}

.profile{
    width:500px;
    background:#ffffff;
    padding:30px;
    border-radius:10px;
    border:1px solid var(--border);
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}


select{
    padding:7px 12px;
    border:1px solid #cfd8df;
    border-radius:6px;
    font-size:14px;
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
    <a href="faculty.php" class="active">FACULTY</a>
    <a href="admin_notification.php">NOTIFICATIONS</a>
    <a href="admin_announcement.php">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php">PROGRAM REGISTRATION</a>
</div>

<div class="content">

<?php
/* ================= PROFILE PAGE ================= */
if($view != ""){

    $view = mysqli_real_escape_string($conn,$view);

    $query = "
        SELECT f.*, d.department_name 
        FROM faculty f
        LEFT JOIN departments d ON f.dept_id = d.dept_id
        WHERE f.emp_no='$view'
    ";

    $q = mysqli_query($conn,$query);

    if(!$q){
        die("View Query Error: ".mysqli_error($conn));
    }

    if(mysqli_num_rows($q) > 0){

        $f = mysqli_fetch_assoc($q);

        echo "
        <div class='profile'>
            <h2>Faculty Profile</h2>
            <p><b>Employee No:</b> {$f['emp_no']}</p>
            <p><b>Name:</b> {$f['name']}</p>
            <p><b>Department:</b> {$f['department_name']}</p>
            <p><b>Designation:</b> {$f['designation']}</p>
            <p><b>Mobile:</b> {$f['mobile']}</p>
            <p><b>Email:</b> {$f['email']}</p>
            <p><b>Qualification:</b> {$f['qualification']}</p>
            <p><b>Specialization:</b> {$f['specialization']}</p>
            <p><b>Experience:</b> {$f['experience_year']} Years</p>

            <a href='faculty.php?delete={$f['emp_no']}&dept={$f['dept_id']}'>
                <button class='delete-btn'>Delete</button>
            </a>

            <a href='faculty.php?dept={$f['dept_id']}'>
                <button class='back-btn'>Back</button>
            </a>
        </div>";
    } else {
        echo "<h3>No Faculty Found</h3>";
    }
}


/* ================= FACULTY LIST ================= */
elseif($dept != ""){

    $dept = mysqli_real_escape_string($conn,$dept);

    echo "<b>Select Department :</b>
    <select onchange=\"location='faculty.php?dept='+this.value\">";

    $dq = mysqli_query($conn,"SELECT * FROM departments WHERE status=1");

    while($d = mysqli_fetch_assoc($dq)){
        $selected = ($dept==$d['dept_id']) ? "selected" : "";
        echo "<option value='{$d['dept_id']}' $selected>{$d['department_name']}</option>";
    }

    echo "</select>";

    echo "<table>
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Action</th>
        </tr>";

    $query = "
        SELECT f.*, d.department_name 
        FROM faculty f
        LEFT JOIN departments d ON f.dept_id = d.dept_id
        WHERE f.dept_id='$dept'
        AND f.status='Active'
    ";

    $q = mysqli_query($conn,$query);

    if(!$q){
        die("List Query Error: ".mysqli_error($conn));
    }

    if(mysqli_num_rows($q) == 0){
        echo "<tr><td colspan='3'>No Faculty Found</td></tr>";
    } else {

        while($f = mysqli_fetch_assoc($q)){
            echo "<tr>
                <td>{$f['name']}</td>
                <td>{$f['designation']}</td>
                <td>
                    <a href='faculty.php?view={$f['emp_no']}'>
                        <button class='view-btn'>View</button>
                    </a>
                </td>
            </tr>";
        }
    }

    echo "</table>";
}


/* ================= DEPARTMENT PAGE ================= */
else{

    echo "<b>Select Department :</b>
    <select onchange=\"location='faculty.php?dept='+this.value\">
        <option value=''>--Select--</option>";

    $q = mysqli_query($conn,"SELECT * FROM departments WHERE status=1");

    while($d = mysqli_fetch_assoc($q)){
        echo "<option value='{$d['dept_id']}'>{$d['department_name']}</option>";
    }

    echo "</select>";
}
?>

</div>
</div>
</body>
</html>
