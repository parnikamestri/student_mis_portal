<?php
session_start();
include "DB.php";

if(!isset($_SESSION['student_id'])){
    header("Location: admission_form.php");
    exit;
}

$student_id = $_SESSION['student_id'];

$upload_folder = "uploads/";

if(!is_dir($upload_folder)){
    mkdir($upload_folder,0777,true);
}

$photo_name = time() . "_" . $_FILES['photo']['name'];
$aadhar_name = time() . "_" . $_FILES['aadhar']['name'];
$marksheet_name = time() . "_" . $_FILES['marksheet']['name'];

move_uploaded_file($_FILES['photo']['tmp_name'], $upload_folder.$photo_name);
move_uploaded_file($_FILES['aadhar']['tmp_name'], $upload_folder.$aadhar_name);
move_uploaded_file($_FILES['marksheet']['tmp_name'], $upload_folder.$marksheet_name);

$sql = "INSERT INTO student_documents
(student_id, photo, aadhar_card, marksheet)
VALUES
('$student_id','$photo_name','$aadhar_name','$marksheet_name')";

if(!mysqli_query($conn,$sql)){
    die("Document Insert Error: " . mysqli_error($conn));
}

echo "<h3>Admission Completed Successfully!</h3>";
?>