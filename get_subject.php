<?php
include("DB.php");
include("faculty_auth.php");

$semester_id = $_GET['semester_id'];

$query = mysqli_query($conn,"
SELECT 
s.subject_id,
s.subject_name,
s.subject_code,
GROUP_CONCAT(stm.subject_type) as types
FROM subject_teacher_mapping stm
JOIN subject s ON s.subject_id = stm.subject_id
WHERE stm.faculty_id='$faculty_id'
AND s.semester_id='$semester_id'
AND stm.status='Active'
GROUP BY s.subject_id
");

echo '<option value="">-- Select Subject --</option>';

while($row=mysqli_fetch_assoc($query)){

$type = $row['types'];

if($type == "Theory,Practical" || $type == "Practical,Theory"){
$type = "Both";
}

echo '<option value="'.$row['subject_id'].'" data-type="'.$type.'">
'.$row['subject_name'].' ('.$row['subject_code'].')
</option>';

}
?>