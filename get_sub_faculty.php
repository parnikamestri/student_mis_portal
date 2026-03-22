<?php
include("DB.php");

$semester_id = $_GET['semester_id'];

$data=[];

$q=mysqli_query($conn,"
SELECT 
subject_id,
subject_name,
subject_code,
subject_type
FROM subject
WHERE semester_id='$semester_id'
AND status='Active'
");

while($r=mysqli_fetch_assoc($q)){
$data[]=$r;
}

echo json_encode($data);
?>