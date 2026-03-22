<?php
include "DB.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $program_id     = $_POST['program_id'];
    $semester_name  = $_POST['semester_name'];
    $semester_no    = $_POST['semester_number'];
    $academic_year  = $_POST['academic_year'];

    $start_date = date("Y-07-01");
    $end_date   = date("Y-06-30", strtotime("+1 year"));
    $status     = "Active";

    $insert = "INSERT INTO semester
              (program_id, semester_name, semester_number, academic_year, start_date, end_date, status, created_at)
              VALUES
              ('$program_id','$semester_name','$semester_no','$academic_year',
               '$start_date','$end_date','$status',NOW())";

    if(mysqli_query($conn,$insert)){
        echo "<script>
                alert('Semester Registered Successfully!');
                window.location.href='Semester_Registration.php';
              </script>";
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>
