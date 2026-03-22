<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=mid_exam_marks.xls");

$students = [
    [1,"23140210197","Manali Suresh Juvale"],
    [2,"23140210198","Sharvari Santosh Sawant"],
    [3,"23140210199","Shravani Dhananjay Soshte"],
    [4,"23140210200","Shivani Shivaji Salvi"],
    [5,"23140210201","Parnika Vishwanath Mestri"],
    [6,"23140210202","Mayuri Mangesh Bane"],
    [7,"23140210203","Vaidehi Dattaram Medhekar"],
];
?>

<table border="1">
<tr>
    <th>SR NO</th>
    <th>ENROLLMENT NO</th>
    <th>STUDENT NAME</th>
    <th>TOTAL</th>
</tr>

<?php foreach($students as $s){ ?>
<tr>
    <td><?= $s[0] ?></td>
    <td><?= $s[1] ?></td>
    <td><?= $s[2] ?></td>
    <td>70</td>
</tr>
<?php } ?>
</table>
