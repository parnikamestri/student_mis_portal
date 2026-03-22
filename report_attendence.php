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
    --primary-dark:#3b5872;
    --accent:#8aa9c2;
    --bg:#f4f7f9;
    --card:#ffffff;
    --border:#d6e2ea;
    --text:#2c3e50;
}

/* BASE */
body{
    margin:0;
    font-family:Segoe UI, Arial, sans-serif;
    background:var(--bg);
    color:var(--text);
}

/* TOPBAR */
.topbar{
    background:linear-gradient(90deg,var(--primary),var(--primary-dark));
    padding:15px 25px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:relative;
}

/* LAYOUT */
.layout{display:flex;}

/* SIDEBAR */
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

/* CONTENT */
.content{
    flex:1;
    padding:40px;
    background:#fff;
}

/* TABLE */
table{
    background:#fff;
    border-radius:10px;
    overflow:hidden;
}
table thead{
    background:#f4f6f8;
}
table th{
    font-weight:600;
    color:#34495e;
}
table tbody tr:hover{
    background:#f8fbfd;
}

/* EXPORT BUTTON */
.export-btn{
    margin-top:20px;
    padding:10px 30px;
    border-radius:25px;
    background:var(--accent);
    font-weight:600;
    border:none;
    color:white;
    transition:.25s;
}
.export-btn:hover{
    background:var(--primary);
    transform:translateY(-1px);
}

/* BACK BUTTON */
.back-btn{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    width:36px;
    height:36px;
    background:rgba(255,255,255,0.18);
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.back-btn:hover{background:rgba(255,255,255,0.3);}
.back-btn svg{stroke:#fff;}
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
        <a href="marks_entry.php">Marks Entry</a>
        <a href="reports.php" class="active">Reports</a>
        <a href="notifications.php">Notifications</a>
        <a href="class_wise_students.php">Class-wise Student List</a>
        <a href="announcement.php">Announcements</a>
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
