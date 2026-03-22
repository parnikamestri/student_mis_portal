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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family:Arial; padding:20px; }
        table { width:100%; border-collapse:collapse; }
        table, th, td { border:1px solid black; }
        th, td { padding:8px; text-align:center; }
        .btn-print { margin-bottom:20px; padding:10px 20px; background:#5F82A6; color:white; border:none; border-radius:5px; cursor:pointer; }
    </style>
</head>
<body>

<h3>Attendance Report</h3>
<button class="btn-print" onclick="window.print()">Print / Save as PDF</button>

<table>
    <thead>
        <tr>
            <th>Roll Number</th>
            <th>Student Name</th>
            <th>Attendance Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $s){ ?>
        <tr>
            <td><?php echo $s['roll']; ?></td>
            <td><?php echo $s['name']; ?></td>
            <td><?php echo $s['attendance']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>