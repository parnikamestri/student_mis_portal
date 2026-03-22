<?php
session_start();



if(!isset($_SESSION['name'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] != "Faculty" && $_SESSION['role'] != "HOD"){
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user_id'];
$name       = $_SESSION['name'];
$dept_id    = $_SESSION['dept_id'];
?>