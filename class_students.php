<?php
include "DB.php";
include "faculty_auth.php";


$semester_id = $_POST['semester_id'] ?? 0;

if($semester_id == 0){
    die("Invalid Semester Selected");
}


$semQuery = mysqli_query($conn,
    "SELECT s.semester_number, p.program_code
     FROM semester s
     JOIN program p ON s.program_id = p.program_id
     WHERE s.semester_id = '$semester_id'"
);

if(!$semQuery){
    die("Semester Query Error: " . mysqli_error($conn));
}

$semData = mysqli_fetch_assoc($semQuery);


$studentQuery = mysqli_query($conn,
    "SELECT student_name, enrollment_id
     FROM students
     WHERE semester_id = '$semester_id'
     ORDER BY enrollment_id ASC"
);

if(!$studentQuery){
    die("Student Query Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Class Wise Student List</title>

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
    font-family: "Segoe UI", Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}



.header{
    height:70px;
    background:linear-gradient(135deg,#5f84a9,#4f6d8a);
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.header-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.profile-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    background:white;
    color:#5f84a9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:bold;
}

.header-title{
    font-size:22px;
    font-weight:600;
    letter-spacing:0.5px;
}



.container{
    display:flex;
    height:calc(100vh - 70px);
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
    transition:all 0.25s ease;
}

.sidebar a:hover{
    background:#dde8f0;
    padding-left:28px;
}

.sidebar a.active{
    background:#dde8f0;
    border-left:4px solid var(--primary);
}


.content{
    flex:1;
    padding:30px;
    background:#fff;
}


.badge{
    background:#eef3f7;
    padding:8px 18px;
    border-radius:20px;
    font-weight:600;
    display:inline-block;
    margin-bottom:15px;
}


table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
}
th{
    background:#f4f6f8;
}


.print-btn{
    background:#5aa6c8;
    color:#fff;
    padding:8px 20px;
    border:none;
    border-radius:20px;
    cursor:pointer;
    font-weight:600;
    margin-bottom:15px;
}
.print-btn:hover{
    background:#4f6d8a;
}


@media print {
    .sidebar,
    .topbar,
    .print-btn {
        display:none;
    }
    body{
        background:#fff;
    }
    .content{
        padding:0;
    }
}
.header{
            height:70px;
            background:#5f84a9;
            color:white;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 30px;
        }

        .header-left{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .profile-icon{
            width:42px;
            height:42px;
            border-radius:50%;
            background:white;
            color:#5f84a9;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
        }

        .header-title {
    font-size: 22px;
    font-weight: bold;
}
        .logout{
            color:white;
            text-decoration:none;
            font-size:15px;
        }

        .logout:hover{
            opacity:0.8;
        }
     .logout-btn{
    display:inline-block;
    background: linear-gradient(135deg, #e53935, #c62828);
    color:white;
    padding:8px 16px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition: all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg, #c62828, #b71c1c);
    transform: translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
</style>
</head>

<body>

<div class="header">
    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $name; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>

<div class="container">

    <div class="sidebar">
        <a href="faculty_attendance_select.php">ATTENDANCE</a>
        <a href="marks_entry.php">MARKS ENTRY</a>
        <a href="reports.php">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_wise_students.php" class="active">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMENTS</a>
    </div>

    <div class="content">
        <div class="badge">
            <?= $semData['program_code']; ?> - SEM <?= $semData['semester_number']; ?>
        </div>

        <table>
            <tr>
                <th>Enrollment No</th>
                <th>Student Name</th>
            </tr>

            <?php
            if(mysqli_num_rows($studentQuery) > 0){
                while($s = mysqli_fetch_assoc($studentQuery)){
            ?>
                <tr>
                    <td><?= $s['enrollment_id']; ?></td>
                    <td><?= $s['student_name']; ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='2' align='center'>No Students Found</td></tr>";
            }
            ?>
        </table>
        <div>
            
    <button class="print-btn" onclick="window.print()">Print</button>
    </div>
    </div>
    
</div>

</body>
</html>