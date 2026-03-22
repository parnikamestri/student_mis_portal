<?php
include("db.php");

$dept_id = $_GET['dept_id'] ?? '';

$options = "<option value=''>SELECT SEMESTER</option>";

if($dept_id != ""){
    $query = "
    SELECT s.semester_id, s.semester_name, p.program_code
    FROM semester s
    JOIN program p ON s.program_id = p.program_id
    WHERE p.dept_id = '$dept_id'
    ORDER BY s.semester_name
    ";
    $result = mysqli_query($conn,$query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $options .= "<option value='{$row['semester_id']}'>{$row['program_code']} - {$row['semester_name']}</option>";
        }
    }
}

echo $options;