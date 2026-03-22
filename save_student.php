<?php
session_start();
include "DB.php";



$enrollment_id  = $_POST['enrollment_no'];
$student_name   = $_POST['full_name'];
$gender         = $_POST['gender'];
$dob            = $_POST['dob'];
$mobile_no      = $_POST['phone_no'];
$email          = $_POST['email_id'];
$dept_id        = $_POST['dept_id'];
$blood_group    = $_POST['blood_group'];
$caste          = $_POST['caste'];

$admission_year = date("Y") . "-" . (date("Y") + 1);
$status         = "Active";
$default_password = hash("sha256", "student@123");


$sem_query = mysqli_query($conn,"
    SELECT s.semester_id
    FROM semester s
    JOIN program p ON s.program_id = p.program_id
    WHERE p.dept_id = '$dept_id'
    AND s.status = 'Active'
    ORDER BY s.semester_number ASC
    LIMIT 1
");

if(!$sem_query){
    die("Semester Fetch Error: " . mysqli_error($conn));
}

$sem_row = mysqli_fetch_assoc($sem_query);

if(!$sem_row){
    die("No Active Semester Found For Selected Department");
}

$semester_id = $sem_row['semester_id'];



$student_sql = "INSERT INTO students
(enrollment_id, student_name, gender, dob, blood_group, caste,
 mobile_no, email, admission_year, dept_id, semester_id,
 password, status)
VALUES
('$enrollment_id','$student_name','$gender','$dob',
 '$blood_group','$caste','$mobile_no','$email',
 '$admission_year','$dept_id','$semester_id',
 '$default_password','$status')";

if (!mysqli_query($conn, $student_sql)) {
    die("Student Insert Error: " . mysqli_error($conn));
}

$student_id = mysqli_insert_id($conn);



$father_occupation   = $_POST['father_occupation'];
$annual_income       = $_POST['annual_income'];
$hostel_required     = $_POST['hostel_required'];
$scholarship_applied = $_POST['scholarship_applied'];
$permanent_address   = $_POST['permanent_address'];
$local_address       = $_POST['local_address'];

$add_sql = "INSERT INTO student_additional_details
(student_id, father_occupation, annual_income,
 hostel_required, scholarship_applied,
 permanent_address, local_address)
VALUES
('$student_id','$father_occupation','$annual_income',
 '$hostel_required','$scholarship_applied',
 '$permanent_address','$local_address')";

if (!mysqli_query($conn, $add_sql)) {
    die("Additional Details Insert Error: " . mysqli_error($conn));
}


$exam_seat_no = $_POST['exam_seat_no'];
$status_arr   = $_POST['status'];
$month_year   = $_POST['month_year'];
$total_marks  = $_POST['total_marks'];

for ($i = 0; $i < count($exam_seat_no); $i++) {

    $year_label = "Year " . ($i + 1);

    $acad_sql = "INSERT INTO academic_details
    (student_id, year_label, exam_seat_no, status, month_year, total_marks)
    VALUES
    ('$student_id','$year_label',
     '{$exam_seat_no[$i]}','{$status_arr[$i]}',
     '{$month_year[$i]}','{$total_marks[$i]}')";

    if (!mysqli_query($conn, $acad_sql)) {
        die("Academic Insert Error: " . mysqli_error($conn));
    }
}



$_SESSION['student_id'] = $student_id;

header("Location: upload_document.php");
exit;

?>