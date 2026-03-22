<?php
include("DB.php");

$subject_id = $_POST['subject_id'];
$exam_id    = $_POST['exam_id'];
$marks      = $_POST['marks'];

$year = "2024-25";

foreach($marks as $student_id=>$obtained){

if($obtained=="") continue;

mysqli_query($conn,"
INSERT INTO marks_report
(student_id,exam_id,subject_id,marks_obtained,academic_year)
VALUES
('$student_id','$exam_id','$subject_id','$obtained','$year')
");

}

echo "<script>alert('Mid Exam Marks Saved');window.history.back();</script>";
?>