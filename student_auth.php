<?php
include "DB.php";
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit;
}
$username     = $_SESSION['student_name'];  
$enrollmentId = $_SESSION['username'];
$studentId = $_SESSION['student_id'];
$studentDept = $_SESSION['dept_id'] ?? 0;
?>