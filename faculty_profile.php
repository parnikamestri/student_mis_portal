<?php
session_start();
$_SESSION['report_type'] = "attendance"; // Attendance report type

// Dynamic attendance data
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
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
    --primary:#4f6d8a;
    --primary-dark:#3d5a73;
    --accent:#5aa6c8;
    --bg:#f4f7f9;
    --card:#ffffff;
    --border:#d6e2ea;
    --text:#2c3e50;
    --muted:#6b7c8f;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}
        .topbar { 
            background:#5F82A6; 
            padding:15px 25px; 
            color:white; 
            display:flex; 
            justify-content:space-between; 
            align-items:center;
            position:relative;
        }
        .layout { display:flex; }
        .sidebar{
    width:260px;
    background:#e6f1f4;
    }
    .sidebar{
    width:260px;
    background:#eef3f7;
    border-right:1px solid var(--border);
}
.sidebar a{
    display:block;
    padding:18px 22px;
    border-bottom:1px solid #dbe6ed;
    text-decoration:none;
    color:var(--text);
    font-size:14px;
    font-weight:600;
    transition:0.25s;
}
.sidebar a:hover{
    background:#dde8f0;
    padding-left:28px;
}
.sidebar a.active{
    background:#dde8f0;
    border-left:4px solid var(--primary);
}
        .content { flex:1; padding:40px; }
        table { background:white; }
        .export-btn { margin-top:20px; padding:10px 30px; border-radius:20px; background:#8aa9c2; font-weight:bold; border:none; color:white; text-decoration:none; }
        .export-btn:hover { background:#7191b2; }

        /* ===== BACK BUTTON (ONLY CHANGE) ===== */
        .back-btn{
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            width:36px;
            height:36px;
            background:rgba(255,255,255,0.15);
            border-radius:8px;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
        }
        .back-btn svg{
            width:18px;
            height:18px;
            stroke:#fff;
        }
        .back-btn:hover{
            background:rgba(255,255,255,0.25);
        }
    </style>
</head>
<body>

<div class="topbar">

    <!-- BACK BUTTON -->
    <a href="report_subject.php" class="back-btn" title="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
        </svg>
    </a>

    <h4 class="ms-5">Faculty Profile</h4>
    <a href="logout.php" style="color:white; text-decoration:none;">Sign Out</a>
</div>

<div class="layout">
    <div class="sidebar">
        <a href="faculty_attendance_select.php">ATTENDANCE</a>
        <a href="marks_entry.php">MARKS ENTRY</a>
        <a href="reports.php" class="active">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMENTS</a>
    </div>

    <div class="content">
        <h4>Attendance Report</h4>
        <hr><br>

        <table class="table table-bordered text-center">
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

        <a href="export_attendence.php" class="btn export-btn">Export Excel</a>
        <a href="print_attendence.php" class="btn export-btn">Export PDF</a>

    </div>
</div>

</body>
</html>
