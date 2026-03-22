<?php
include "DB.php";

$subject_id = $_GET['subject_id'];

$q = mysqli_query($conn,"
SELECT exam_id, exam_name
FROM exam
WHERE subject_id='$subject_id'
");

$data = [];
$unit_added = false;

while($row = mysqli_fetch_assoc($q)){

    if($row['exam_name'] == "Unit Test 1" || $row['exam_name'] == "Unit Test 2"){

        if(!$unit_added){
            $data[] = [
                "exam_id" => "unit_test",
                "exam_name" => "Unit Test"
            ];
            $unit_added = true;
        }

    }else{
        $data[] = $row;
    }

}

echo json_encode($data);
?>