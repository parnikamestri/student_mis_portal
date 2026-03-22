<?php
include("DB.php");
session_start();

$subject_id = $_POST['subject_id'] ?? '';
$theory     = $_POST['theory'] ?? '';
$practical  = $_POST['practical'] ?? '';

$year = date("Y")."-".(date("Y")+1);
$assigned_by = $_SESSION['hod_id'];

/* THEORY INSERT */

if($theory!=""){

mysqli_query($conn,"
INSERT INTO subject_teacher_mapping
(faculty_id,subject_id,subject_type,academic_year,assigned_by,status)
VALUES
('$theory','$subject_id','Theory','$year','$assigned_by','Active')
");

}

/* PRACTICAL INSERT */

if($practical!=""){

mysqli_query($conn,"
INSERT INTO subject_teacher_mapping
(faculty_id,subject_id,subject_type,academic_year,assigned_by,status)
VALUES
('$practical','$subject_id','Practical','$year','$assigned_by','Active')
");

}

echo "Faculty Assigned Successfully";

?>