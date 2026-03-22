<?php
include("DB.php");

$semester_id = $_GET['semester'] ?? 0;
$subject_id  = $_GET['subject'] ?? 0;

/* SUBJECT DETAILS */
$subjectQuery = mysqli_query($conn,"
SELECT subject_name, sla_marks
FROM subject
WHERE subject_id='$subject_id'
");

$subject = mysqli_fetch_assoc($subjectQuery);

$subject_name = $subject['subject_name'] ?? '';
$total_marks  = $subject['sla_marks'] ?? 0;


/* SLA EXAM */
$examQuery = mysqli_query($conn,"
SELECT exam_id
FROM exam
WHERE subject_id='$subject_id'
AND exam_name LIKE 'SLA%'
LIMIT 1
");

$exam = mysqli_fetch_assoc($examQuery);
$exam_id = $exam['exam_id'] ?? 0;


/* STUDENTS */
$studentQuery = mysqli_query($conn,"
SELECT student_id,enrollment_id,student_name
FROM students
WHERE semester_id='$semester_id'
AND status='Active'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>SLA Marks Entry</title>

<style>

:root{
--primary:#4f6d8a;
--bg:#f4f7f9;
--card:#ffffff;
--border:#d6e2ea;
}

body{
background:var(--bg);
font-family:Segoe UI;
}

.container{
width:90%;
margin:40px auto;
background:white;
padding:25px;
border-radius:8px;
}

.header{
background:#5f84a9;
color:white;
padding:15px;
text-align:center;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
border:1px solid #ccc;
padding:10px;
text-align:center;
}

th{
background:#eef3f7;
}

input{
width:60px;
}

.buttons{
margin-top:20px;
display:flex;
gap:15px;
}

button{
padding:10px 20px;
border:none;
border-radius:20px;
cursor:pointer;
}

.save{
background:#4f6d8a;
color:white;
}

</style>
</head>

<body>

<div class="header">
SLA Marks Entry
</div>

<div class="container">

<h3>Subject : <?php echo $subject_name; ?></h3>

<form method="POST" action="save_sla_marks.php">

<input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
<input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">

<table>

<tr>
<th>SR NO</th>
<th>ENROLLMENT</th>
<th>STUDENT NAME</th>
<th>MARKS</th>
<th>TOTAL</th>
</tr>

<?php
$sr=1;

while($stu=mysqli_fetch_assoc($studentQuery)){
?>

<tr>

<td><?php echo $sr++; ?></td>

<td><?php echo $stu['enrollment_id']; ?></td>

<td><?php echo $stu['student_name']; ?></td>

<td>
<input type="number"
name="marks[<?php echo $stu['student_id']; ?>]"
min="0"
max="<?php echo $total_marks; ?>">
</td>

<td><?php echo $total_marks; ?></td>

</tr>

<?php } ?>

</table>

<div class="buttons">

<button class="save">Save Marks</button>

<a href="?export=excel">
<button type="button">Export Excel</button>
</a>

<a href="?export=pdf">
<button type="button">Export PDF</button>
</a>

<button type="button" onclick="window.print()">Print</button>

</div>

</form>

</div>

</body>
</html>