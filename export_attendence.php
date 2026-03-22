<?php
session_start();
if(!isset($_SESSION['report_type']) || $_SESSION['report_type'] != "attendance"){
    header("Location: report_attendance.php");
    exit();
}

// Hardcoded attendance data
$students = [
    ["roll"=>"3201","name"=>"Manali Suresh Juvale","attendance"=>"90%"],
    ["roll"=>"3202","name"=>"Parnika Vishwanath Mestri","attendance"=>"91%"],
    ["roll"=>"3203","name"=>"Vaidehi Medhekar","attendance"=>"92%"],
    ["roll"=>"3204","name"=>"Sharvari Santosh Sawant","attendance"=>"93%"],
    ["roll"=>"3205","name"=>"Shravani Soshthe","attendance"=>"94%"],
    ["roll"=>"3206","name"=>"Shivani Salvi","attendance"=>"95%"],
    ["roll"=>"3207","name"=>"Mayuri Mangesh Bane","attendance"=>"96%"],
];

// Excel headers
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report.xls");

// Column headers
echo "Roll Number\tStudent Name\tAttendance Percentage\n";

// Table data
foreach($students as $s){
    echo $s['roll']."\t".$s['name']."\t".$s['attendance']."\n";
}
?>