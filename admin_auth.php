<?php
include "DB.php";
session_start();

if(!isset($_SESSION['admin_name']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['admin_name'];
?>