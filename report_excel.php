<?php
session_start();

// Example data (same as above)
$students = [
    ["roll"=>"3201","name"=>"Manali Suresh Juvale","marks"=>"30/30"],
    ["roll"=>"3202","name"=>"Parnika Vishvanath Mestri","marks"=>"30/30"],
    ["roll"=>"3203","name"=>"Vaidehi Dattaram Medhekar","marks"=>"30/30"],
    ["roll"=>"3204","name"=>"Sharvari Santosh Sawant","marks"=>"30/30"],
    ["roll"=>"3205","name"=>"Shravani Dhananjay Soshte","marks"=>"30/30"],
    ["roll"=>"3206","name"=>"Shivani Shivaji Salvi","marks"=>"30/30"],
    ["roll"=>"3207","name"=>"Mayuri Mangesh Bane","marks"=>"30/30"],
];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=faculty_report.xls");

echo "Roll Number\tStudent Name\tUnit Test Marks\n";
foreach($students as $s){
    echo $s['roll'] . "\t" . $s['name'] . "\t" . $s['marks'] . "\n";
}
exit;
?>