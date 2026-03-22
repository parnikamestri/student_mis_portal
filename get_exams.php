<?php
include("DB.php");

$subject_id  = (int) ($_GET['subject_id'] ?? 0);
$semester_id = (int) ($_GET['semester_id'] ?? 0);
$program_id  = (int) ($_GET['program_id'] ?? 0);

$exams = [];

if($subject_id && $semester_id && $program_id){
    $query = mysqli_query($conn, "
        SELECT *
        FROM exam
        WHERE status='Active'
        AND subject_id = $subject_id
        AND semester_id = $semester_id
        AND program_id = $program_id
    ");

    while($row = mysqli_fetch_assoc($query)){
        $exams[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($exams);