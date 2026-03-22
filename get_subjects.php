<?php
include("DB.php");
include("faculty_auth.php");

$semester_id = $_GET['semester_id'];

$query = mysqli_query($conn,"
SELECT 
s.subject_id,
s.subject_name,
s.subject_type
FROM subject_teacher_mapping stm
JOIN subject s ON stm.subject_id = s.subject_id
WHERE stm.faculty_id='$faculty_id'
AND s.semester_id='$semester_id'
AND stm.status='Active'
");

$data = [];

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);
?>