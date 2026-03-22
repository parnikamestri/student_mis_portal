<?php
include "DB.php";

$semester_id = $_GET['semester_id'];
$faculty_id  = $_GET['faculty_id'];

$query = mysqli_query($conn,"
SELECT DISTINCT sub.subject_id, sub.subject_name
FROM subject_teacher_mapping stm
JOIN subject sub ON stm.subject_id=sub.subject_id
WHERE stm.faculty_id='$faculty_id'
AND sub.semester_id='$semester_id'
");

$data=[];

while($row=mysqli_fetch_assoc($query)){
$data[]=$row;
}

echo json_encode($data);