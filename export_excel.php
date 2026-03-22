<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=students.xls");


$students = [
[3201,"Manali Suresh Juvale","23140210197"],
[3202,"Parnika Vishwanath Mestri","23140210198"],
[3203,"Vaidehi Dattaram Medhekar","23140210199"],
[3204,"Sharvari Santosh Sawant","23140210200"],
[3205,"Shravani Dhananjay Soshte","23140210201"],
];


echo "Roll No\tStudent Name\tEnrollment No\n";
foreach($students as $s){
echo "$s[0]\t$s[1]\t$s[2]\n";
}
?>