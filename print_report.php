<?php
session_start();

$report_type = $_SESSION['report_type'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print Report</title>
    <style>
        body{ font-family:Arial; padding:30px; }
        h2{ text-align:center; }
        table{ width:100%; border-collapse:collapse; margin-top:20px; }
        th,td{ border:1px solid #333; padding:8px; text-align:center; }
        .print-btn{
            padding:10px 30px;
            border:none;
            background:#5F82A6;
            color:white;
            font-size:16px;
            border-radius:8px;
            cursor:pointer;
            margin-bottom:20px;
        }
        .print-btn:hover{
            background:#3b5d79;
        }
    </style>
</head>

<body>

<button class="print-btn" onclick="window.print()">PRINT</button>

<h2><?php echo strtoupper($report_type); ?> REPORT</h2>
<hr>

<table>
    <tr>
        <th>Roll</th>
        <th>Name</th>
        <th><?php echo ($report_type=="attendance")?"Attendance":"Marks"; ?></th>
    </tr>

    <tr><td>3201</td><td>Manali Suresh Juvale</td><td><?php echo ($report_type=="attendance")?"90%":"30/30"; ?></td></tr>
    <tr><td>3202</td><td>Parnika Vishwanath Mestri</td><td><?php echo ($report_type=="attendance")?"91%":"30/30"; ?></td></tr>
    <tr><td>3203</td><td>Vaidehi Medhekar</td><td><?php echo ($report_type=="attendance")?"92%":"30/30"; ?></td></tr>
    <tr><td>3204</td><td>Sharvari Santosh Sawant</td><td><?php echo ($report_type=="attendance")?"93%":"30/30"; ?></td></tr>
    <tr><td>3205</td><td>Shravani Soshthe</td><td><?php echo ($report_type=="attendance")?"94%":"30/30"; ?></td></tr>
    <tr><td>3206</td><td>Shivani Salvi</td><td><?php echo ($report_type=="attendance")?"95%":"30/30"; ?></td></tr>
    <tr><td>3207</td><td>Mayuri Mangesh Bane</td><td><?php echo ($report_type=="attendance")?"96%":"30/30"; ?></td></tr>

</table>

</body>
</html>