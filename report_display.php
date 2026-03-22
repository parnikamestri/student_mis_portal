<?php

include "DB.php";
include "faculty_auth.php";

if(!isset($_SESSION['report_type']) || !isset($_SESSION['subject_id'])){
    header("Location: reports.php");
    exit;
}

$type = $_SESSION['report_type'];
$subject_id = $_SESSION['subject_id'];
$semester_id = $_SESSION['semester_id'] ?? null;
$exam_id = $_SESSION['exam_id'] ?? null;

/* SUBJECT DETAILS */

$subQuery = mysqli_query($conn,"
SELECT sub.subject_name,
       sem.semester_number
FROM subject sub
LEFT JOIN semester sem ON sem.semester_id = sub.semester_id
WHERE sub.subject_id = '$subject_id'
");

$subData = mysqli_fetch_assoc($subQuery);

$subject_name = $subData['subject_name'] ?? '';
$semester_number = $subData['semester_number'] ?? '';

/* EXAM NAME */

if($exam_id=="unit_test"){
    $exam_name="Unit Test";
}
else{

$examQ=mysqli_query($conn,"
SELECT exam_name 
FROM exam 
WHERE exam_id='$exam_id'
");

$examData=mysqli_fetch_assoc($examQ);

$exam_name=$examData['exam_name'] ?? '';

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Report</title>



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
padding:30px;
}
.card-box{
    background:white;
    border:1px solid var(--border);
    border-radius:12px;
    padding:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}
.table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
    font-size:14px;
}

.table thead{
    background:linear-gradient(135deg,#5f84a9,#4f6d8a);
    color:white;
}

.table th{
    padding:12px;
    text-align:left;
    font-weight:600;
}

.table td{
    padding:10px 12px;
    border-bottom:1px solid #e3edf3;
}

.table tbody tr:nth-child(even){
    background:#f7fbfd;
}

.table tbody tr:hover{
    background:#eaf3f9;
    transition:0.2s;
}
.print-btn{
    margin-top:18px;
    padding:10px 20px;
    border:none;
    border-radius:6px;
    background:#2e7d32;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.print-btn:hover{
    background:#1b5e20;
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
.report-title{
    font-size:22px;
    font-weight:700;
    color:#2c3e50;
    margin-bottom:10px;
}
.report-info{
    margin-top:10px;
    margin-bottom:15px;
    font-size:15px;
    line-height:1.8;
}

.report-info b{
    color:#4f6d8a;
    font-weight:600;
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
<a href="reports.php" class="active">REPORTS</a>
<a href="notifications.php">NOTIFICATIONS</a>
<a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
<a href="announcement.php">ANNOUNCEMENTS</a>
</div>

<div class="content">
<div class="card-box">

<h3>
<?php echo ($type=="attendance") ? "Attendance Report" : "Marks Report"; ?>
</h3>

<hr>

<div>
<b>Semester :</b> <?php echo $semester_number ?><br>
<b>Subject :</b> <?php echo $subject_name ?><br>

<?php if($type=="marks"){ ?>

<b>Exam :</b> <?php echo $exam_name ?>

<?php } ?>

</div>

<hr>

<?php

/* ATTENDANCE REPORT */

if($type=="attendance"){

$query=mysqli_query($conn,"
SELECT
s.enrollment_id AS 'Enrollment No',
s.student_name AS 'Student Name',
a.total_lectures AS 'Total Lectures',
a.attended_lectures AS 'Attended Lectures',
a.attendance_percentage AS 'Percentage',
a.attendance_status AS 'Status'
FROM attendance_report a
JOIN students s ON s.student_id=a.student_id
WHERE a.subject_id='$subject_id'
AND s.semester_id='$semester_id'
");

}

/* MARKS REPORT */

else{

/* UNIT TEST REPORT */

if($exam_id=="unit_test"){

$query=mysqli_query($conn,"
SELECT
s.enrollment_id AS 'Enrollment No',
s.student_name AS 'Student Name',

MAX(CASE WHEN e.exam_name='Unit Test 1'
THEN m.marks_obtained END) AS 'Unit Test 1',

MAX(CASE WHEN e.exam_name='Unit Test 2'
THEN m.marks_obtained END) AS 'Unit Test 2',

CASE 
WHEN 
MAX(CASE WHEN e.exam_name='Unit Test 1' THEN m.marks_obtained END) IS NOT NULL
AND
MAX(CASE WHEN e.exam_name='Unit Test 2' THEN m.marks_obtained END) IS NOT NULL

THEN ROUND(
(
MAX(CASE WHEN e.exam_name='Unit Test 1' THEN m.marks_obtained END)
+
MAX(CASE WHEN e.exam_name='Unit Test 2' THEN m.marks_obtained END)
)/2 ,2)

ELSE NULL
END AS 'Average'

FROM marks_report m
JOIN students s ON s.student_id=m.student_id
JOIN exam e ON e.exam_id=m.exam_id

WHERE m.subject_id='$subject_id'
AND s.semester_id='$semester_id'
AND e.exam_name IN ('Unit Test 1','Unit Test 2')

GROUP BY s.student_id
");
}

/* OTHER EXAMS */

else{

$query=mysqli_query($conn,"
SELECT
s.enrollment_id AS 'Enrollment No',
s.student_name AS 'Student Name',
m.marks_obtained AS 'Marks'

FROM marks_report m
JOIN students s ON s.student_id=m.student_id

WHERE m.subject_id='$subject_id'
AND m.exam_id='$exam_id'
AND s.semester_id='$semester_id'
");

}

}

if(mysqli_num_rows($query)==0){

echo "No Records Found";

}

else{

?>

<table class="table">

<thead>
<tr>

<?php
while($field=mysqli_fetch_field($query)){
echo "<th>".$field->name."</th>";
}
?>

</tr>
</thead>

<tbody>

<?php
while($row=mysqli_fetch_assoc($query)){

echo "<tr>";

foreach($row as $data){
echo "<td>".$data."</td>";
}

echo "</tr>";
}
?>

</tbody>

</table>

<button onclick="printReport()" class="print-btn">
Print Report
</button>

<?php } ?>

</div>
</div>
</div>

<script>

function printReport(){

var printContents=document.querySelector(".card-box").innerHTML;
var originalContents=document.body.innerHTML;

document.body.innerHTML=printContents;
window.print();
document.body.innerHTML=originalContents;

location.reload();

}

</script>

</body>
</html>