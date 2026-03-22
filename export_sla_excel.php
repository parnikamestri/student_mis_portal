<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=SLA_Marks.xls");

echo "Enrollment No\tStudent Name\tMarks\tTotal\n";

$students = [
    ["23140210197","Manali Suresh Juvale"],
    ["23140210198","Sharvari Santosh Sawant"],
    ["23140210199","Shravani Dhananjay Soshte"],
    ["23140210200","Shivani Shivaji Salvi"],
    ["23140210201","Parnika Vishwanath Mestri"],
    ["23140210202","Mayuri Mangesh Bane"],
    ["23140210203","Vaidehi Dattaram Medhekar"]
];

$marks = $_POST['marks'] ?? [];

foreach($students as $i => $s){
    $m = $marks[$i] ?? '';
    echo "$s[0]\t$s[1]\t$m\t30\n";
}
?>
