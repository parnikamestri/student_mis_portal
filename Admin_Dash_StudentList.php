<?php
include "DB.php";
include "admin_auth.php";

$department     = $_POST['department']     ?? '';
$semester       = $_POST['semester']       ?? '';
$showList       = isset($_POST['load']);

$students = [];
if($showList && $department != "" && $semester != ""){
    $query = "
    SELECT 
        s.student_id,
        s.student_name,
        s.enrollment_id,
        s.status
    FROM students s
    WHERE s.dept_id='$department' 
      AND s.semester_id='$semester'
    ORDER BY s.student_name ASC
    ";
    $result = mysqli_query($conn,$query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $students[$row['student_id']] = $row;
        }
    } else {
        die("Student Query Error: ".mysqli_error($conn));
    }
}

if(isset($_GET['deactivate'])){
    $sid = $_GET['deactivate'];
    mysqli_query($conn,"UPDATE students SET status='Inactive' WHERE student_id='$sid'");
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


if(isset($_GET['export']) && $_GET['export']=="excel"){
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=student_list.xls");
    echo "ID\tName\tEnrollment\tStatus\n";
    $query = "SELECT student_id, student_name, enrollment_id, status FROM students";
    $result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($result)){
        echo "{$row['student_id']}\t{$row['student_name']}\t{$row['enrollment_id']}\t{$row['status']}\n";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student List</title>
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
    padding:30px;
    background:#fff;
    margin:20px;
    border-radius:10px;
    border:1px solid #dfe6ec;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}



select,
input,
button{
    padding:9px 14px;
    border-radius:6px;
    border:1px solid #c3cbd2;
    font-size:13px;
}

select,
input{
    background:#fff;
}

button{
    background:#3f6fa1;
    color:#fff;
    cursor:pointer;
    border:none;
    transition:0.2s;
}

button:hover{
    background:#345f8c;
    transform:translateY(-1px);
}



.info-bar{
    background:#f0f6fb;
    border:1px solid #d6e3ef;
    padding:12px 18px;
    margin-top:25px;
    font-weight:600;
    border-radius:6px;
    font-size:14px;
}



.search-box{
    margin-top:18px;
}



table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    font-size:14px;
}

th,
td{
    border:1px solid #d3dbe2;
    padding:12px;
    text-align:center;
}

th{
    background:#f1f5f9;
    font-weight:600;
}

tr:nth-child(even){
    background:#fafbfd;
}

td a{
    color:#3f6fa1;
    text-decoration:none;
    font-weight:600;
}

td a:hover{
    text-decoration:underline;
}

.actions{
    margin-top:30px;
    display:flex;
    gap:12px;
}

@media print{

    .sidebar,
    .topbar,
    .actions,
    .search-box{
        display:none;
    }

    .content{
        margin:0;
        box-shadow:none;
        border:none;
    }

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
    <a href="Admin_Dash_StudentList.php" class="active">STUDENT</a>
    <a href="faculty.php">FACULTY</a>
    <a href="admin_notification.php">NOTIFICATIONS</a>
    <a href="admin_announcement.php">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php">PROGRAM REGISTRATION</a>
</div>

<div class="content">
<form method="post">
<b>Select Department :</b>
<select name="department" id="department" required>
<option value="">SELECT DEPARTMENT</option>
<?php
$deptQuery = mysqli_query($conn,"SELECT dept_id, department_name FROM departments");
while($d=mysqli_fetch_assoc($deptQuery)){
    $sel=($department==$d['dept_id'])?"selected":"";
    echo "<option value='{$d['dept_id']}' $sel>{$d['department_name']}</option>";
}
?>
</select>
<br><br>

<b>Select Semester :</b>
<select name="semester" id="semester" required>
<option value="">SELECT SEMESTER</option>
<?php
if(!empty($department)){
    $semQuery = mysqli_query($conn,"
        SELECT s.semester_id, s.semester_name, p.program_code
        FROM semester s
        JOIN program p ON s.program_id = p.program_id
        WHERE p.dept_id = '$department'
        ORDER BY s.semester_name
    ");
    while($s=mysqli_fetch_assoc($semQuery)){
        $sel = ($semester==$s['semester_id'])?"selected":""; 
        echo "<option value='{$s['semester_id']}' $sel>{$s['program_code']} - {$s['semester_name']}</option>";
    }
}
?>
</select>
<br><br>
<button name="load">Load Student List</button>
</form>

<?php if($showList && !empty($students)): ?>
<div class="info-bar">
Department: <?= $department ?> | Semester: <?= $semester ?>
</div>

<div class="search-box">
<input type="text" id="searchInput" placeholder="Search by Enrollment or Name" onkeyup="searchTable()">
</div>

<table id="studentTable">
<tr>
<th>Roll No</th><th>Name</th><th>Enrollment</th><th>Status</th><th>Action</th>
</tr>
<?php foreach($students as $s): ?>
<tr>
<td><?= $s['student_id'] ?></td>
<td><?= $s['student_name'] ?></td>
<td><?= $s['enrollment_id'] ?></td>
<td><?= $s['status'] ?></td>
<td>
<a href="view_student.php?id=<?= $s['student_id'] ?>">View</a> |
<a href="?deactivate=<?= $s['student_id'] ?>" onclick="return confirm('Are you sure to deactivate this student?')">Deactivate</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<div class="actions">
<button onclick="downloadPDF()">Export PDF</button>
<a href="?export=excel"><button type="button">Export Excel</button></a>
<button type="button" onclick="window.print()">Print</button>
</div>
<?php elseif($showList): ?>
<p>No students found for selected department and semester.</p>
<?php endif; ?>
</div>
</div>

<script>
function searchTable(){
    let input=document.getElementById("searchInput").value.toLowerCase();
    document.querySelectorAll("#studentTable tr:not(:first-child)").forEach(row=>{
        row.style.display=row.innerText.toLowerCase().includes(input)?"":"none";
    });
}

function downloadPDF(){
    const { jsPDF } = window.jspdf;
    let doc=new jsPDF();
    doc.text("Student List",14,15);
    let y=25;
    document.querySelectorAll("#studentTable tr").forEach((row,i)=>{
        if(i==0) return;
        let td=row.querySelectorAll("td");
        doc.text(`${td[0].innerText}  ${td[1].innerText}  ${td[2].innerText}  ${td[3].innerText}`,14,y);
        y+=8;
    });
    doc.save("student_list.pdf");
}

// AJAX for semester load (optional)
document.getElementById("department").addEventListener("change", function(){
    let dept_id = this.value;
    let semesterSelect = document.getElementById("semester");
    semesterSelect.innerHTML = "<option>Loading...</option>";
    fetch("fetch_semesters.php?dept_id=" + dept_id)
    .then(response => response.text())
    .then(data => { semesterSelect.innerHTML = data; })
    .catch(err => {
        semesterSelect.innerHTML = "<option value=''>Error loading semesters</option>";
        console.error(err);
    });
});
</script>

</body>
</html>