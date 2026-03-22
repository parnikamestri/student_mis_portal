<?php
include("DB.php");

if($_SERVER['REQUEST_METHOD']=="POST"){

$subject_id = $_POST['subject_id'];
$exam_id    = $_POST['exam_id'];
$marks      = $_POST['marks'];

$academic_year = date("Y");

foreach($marks as $student_id => $mark){

$student_id = intval($student_id);
$mark       = intval($mark);



$check = mysqli_query($conn,"
SELECT * FROM marks_report
WHERE student_id='$student_id'
AND subject_id='$subject_id'
AND exam_id='$exam_id'
");

if(mysqli_num_rows($check)==0){

mysqli_query($conn,"
INSERT INTO marks_report
(student_id,exam_id,subject_id,marks_obtained,academic_year)
VALUES
('$student_id','$exam_id','$subject_id','$mark','$academic_year')
");

}else{

mysqli_query($conn,"
UPDATE marks_report
SET marks_obtained='$mark'
WHERE student_id='$student_id'
AND subject_id='$subject_id'
AND exam_id='$exam_id'
");

}

}

echo "<script>
alert('Marks Saved Successfully');
window.history.back();
</script>";

}
?>