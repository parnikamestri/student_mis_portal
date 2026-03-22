<?php
include("db.php");

$student_id = $_GET['id'] ?? '';
if(empty($student_id)){
    die("Invalid student ID. Make sure ?id=STUDENT_ID is passed in URL.");
}


$query = "SELECT * FROM students WHERE student_id='$student_id'";
$result = mysqli_query($conn,$query);
if(!$result || mysqli_num_rows($result)==0){
    die("Student not found.");
}
$student = mysqli_fetch_assoc($result);

$student['department_name']='';
if(!empty($student['dept_id'])){
    $res=mysqli_query($conn,"SELECT department_name FROM departments WHERE dept_id='{$student['dept_id']}'");
    if($res && mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $student['department_name']=$row['department_name'];
    }
}

$student['semester_name']='';
if(!empty($student['semester_id'])){
    $res=mysqli_query($conn,"SELECT semester_name FROM semester WHERE semester_id='{$student['semester_id']}'");
    if($res && mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $student['semester_name']=$row['semester_name'];
    }
}


$student['academic_year_name']='';
if(!empty($student['academic_year_id'])){
    $res=mysqli_query($conn,"SELECT year_name FROM academic_year WHERE academic_year_id='{$student['academic_year_id']}'");
    if($res && mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $student['academic_year_name']=$row['year_name'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>
<style>
body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7f9;color:#2c3e50;padding:30px;}
.card{background:#fff;padding:25px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.05);max-width:700px;margin:auto;}
h2{text-align:center;color:#3f6fa1;margin-bottom:25px;}
table{width:100%;border-collapse:collapse;}
td{padding:10px;border-bottom:1px solid #dfe6ec;}
td.label{width:35%;font-weight:600;color:#555;}
button{padding:10px 18px;background:#3f6fa1;color:#fff;border:none;border-radius:6px;cursor:pointer;transition:0.2s;}
button:hover{background:#345f8c;}
a{text-decoration:none;}
</style>
</head>
<body>

<div class="card">
<h2>Student Profile</h2>
<table>
<tr><td class="label">Student ID</td><td><?= $student['student_id'] ?></td></tr>
<tr><td class="label">Name</td><td><?= $student['student_name'] ?></td></tr>
<tr><td class="label">Enrollment ID</td><td><?= $student['enrollment_id'] ?></td></tr>
<tr><td class="label">Email</td><td><?= $student['email'] ?></td></tr>
<tr><td class="label">Phone</td><td><?= $student['mobile_no'] ?></td></tr>
<tr><td class="label">Gender</td><td><?= $student['gender'] ?></td></tr>
<tr><td class="label">Date of Birth</td><td><?= $student['dob'] ?></td></tr>
<tr><td class="label">Department</td><td><?= $student['department_name'] ?></td></tr>
<tr><td class="label">Semester</td><td><?= $student['semester_name'] ?></td></tr>
<tr><td class="label">Academic Year</td><td><?= $student['admission_year'] ?></td></tr>
<tr><td class="label">Status</td><td><?= $student['status'] ?></td></tr>
</table>
<br>
<a href="Admin_Dash_StudentList.php"><button>Back to List</button></a>
</div>

</body>
</html>