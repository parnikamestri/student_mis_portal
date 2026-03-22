<?php
include "DB.php";

$subject_id = $_GET['subject_id'];
$faculty_id = $_GET['faculty_id'];

$query = mysqli_query($conn,"
SELECT subject_type
FROM subject_teacher_mapping
WHERE faculty_id='$faculty_id'
AND subject_id='$subject_id'
");

$types=[];

while($row=mysqli_fetch_assoc($query)){

if($row['subject_type']=="theory"){
$types[]="Theory";
}

if($row['subject_type']=="practical"){
$types[]="Practical";
}

}

echo json_encode($types);