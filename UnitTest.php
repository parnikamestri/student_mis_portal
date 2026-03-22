<?php
include("DB.php");

$semester_id = $_GET['semester'] ?? 0;
$subject_id  = $_GET['subject'] ?? 0;

$subjectQuery = mysqli_query($conn,"
SELECT subject_name, fa_th_marks
FROM subject
WHERE subject_id='$subject_id'
");

if(!$subjectQuery){
    die("Subject Query Error: ".mysqli_error($conn));
}

$subject = mysqli_fetch_assoc($subjectQuery);

$subject_name = $subject['subject_name'] ?? '';
$total_marks  = $subject['fa_th_marks'] ?? 0;



$examQuery = mysqli_query($conn,"
SELECT exam_id, exam_name
FROM exam
WHERE subject_id='$subject_id'
AND exam_name LIKE 'Unit Test%'
");

if(!$examQuery){
    die("Exam Query Error: ".mysqli_error($conn));
}



$studentQuery = mysqli_query($conn,"
SELECT student_id,enrollment_id,student_name
FROM students
WHERE semester_id='$semester_id'
AND status='Active'
");

if(!$studentQuery){
    die("Student Query Error: ".mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Unit Test Marks Entry</title>

<style>

:root{
--primary:#4f6d8a;
--primary-dark:#3d5a73;
--bg:#f4f7f9;
--card:#ffffff;
--border:#d6e2ea;
--text:#2c3e50;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Segoe UI, Arial, sans-serif;
}

body{
background:var(--bg);
}



.header{
background:var(--primary);
color:white;
padding:18px;
text-align:center;
font-size:20px;
font-weight:600;
letter-spacing:.5px;
}



.container{
width:92%;
margin:30px auto;
background:var(--card);
padding:30px;
border-radius:10px;
box-shadow:0 4px 15px rgba(0,0,0,0.08);
}


.subject{
font-size:20px;
font-weight:600;
color:var(--text);
margin-bottom:20px;
}



select{
padding:8px 14px;
border-radius:6px;
border:1px solid var(--border);
font-size:14px;
outline:none;
}



table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:#eef3f7;
padding:12px;
font-weight:600;
font-size:14px;
}

td{
padding:10px;
border-bottom:1px solid var(--border);
font-size:14px;
}

tr:hover{
background:#f8fbfd;
}

input{
width:70px;
padding:6px;
border:1px solid var(--border);
border-radius:5px;
text-align:center;
}



.save-btn{
margin-top:25px;
padding:12px 45px;
background:var(--primary);
color:white;
border:none;
border-radius:30px;
font-size:15px;
cursor:pointer;
transition:.2s;
}

.save-btn:hover{
background:var(--primary-dark);
}

.center{
text-align:center;
}

</style>
</head>

<body>

<div class="header">
Unit Test Marks Entry
</div>

<div class="container">

<div class="subject">
Subject : <?php echo $subject_name; ?>
</div>

<form method="POST" action="save_unit_marks.php">

<input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">

<label><b>Select Unit Test</b></label>
<br><br>

<select name="exam_id" required>
<option value="">-- Select Unit Test --</option>

<?php while($exam=mysqli_fetch_assoc($examQuery)){ ?>

<option value="<?php echo $exam['exam_id']; ?>">
<?php echo $exam['exam_name']; ?>
</option>

<?php } ?>

</select>


<table>

<tr>
<th>SR NO</th>
<th>Enrollment</th>
<th>Student Name</th>
<th>Marks Obtained</th>
<th>Total</th>
</tr>

<?php 
$sr=1;

if(mysqli_num_rows($studentQuery) > 0){

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

<?php 
}

}else{
?>

<tr>
<td colspan="5" class="center">No Students Found</td>
</tr>

<?php } ?>

</table>

<div class="center">
<button class="save-btn">Save Marks</button>
</div>

</form>

</div>

</body>
</html>