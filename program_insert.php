<?php
include "DB.php";

if (isset($_POST['register'])) {

    $program_name     = $_POST['program_name'];
    $program_code     = $_POST['program_code'];
    $level            = $_POST['level'];
    $duration_years   = $_POST['duration_years'];
    $total_semesters  = $_POST['total_semesters'];
    $dept_id          = $_POST['dept_id'];

    $sql = "INSERT INTO program 
            (program_name, program_code, level, duration_years, total_semesters, dept_id)
            VALUES
            ('$program_name', '$program_code', '$level', '$duration_years', '$total_semesters', '$dept_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Program Registered Successfully'); window.location='program_registration.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
