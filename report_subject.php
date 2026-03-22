<?php
session_start();

if(!isset($_SESSION['report_type'])){
    header("Location: reports.php");
    exit;
}

if(isset($_POST['generate'])){
    $_SESSION['subject'] = $_POST['subject'];

    if($_SESSION['report_type'] == "attendance"){
        header("Location: report_attendence.php");
        exit();
    }
    else if($_SESSION['report_type'] == "marks"){
        header("Location: faculty_profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Profile - Reports</title>
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

.topbar{
    background:linear-gradient(90deg,#4f6d8a,#3b5872);
    color:white;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:relative;
}


.layout{
    display:flex;
    
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


.content{
    flex:1;
    padding:30px;
}


.report-box{
    background:#fff;
    border:1px solid #d6e2ea;
    border-radius:12px;
    padding:30px;
    height:100%;
}

.report-select{
    width:230px;
    border-radius:20px;
    padding:9px 15px;
    border:1px solid #ccc;
}

.submit-btn{
    margin-top:180px;
    padding:12px 42px;
    border-radius:25px;
    background:#5f82a6;
    border:none;
    color:white;
    font-weight:600;
    transition:.25s;
}
.submit-btn:hover{
    background:#4f6d8a;
    transform:translateY(-1px);
}

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

    
    <a href="reports.php" class="back-btn" title="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
        </svg>
    </a>

    <h4 class="ms-5">Faculty Profile</h4>
    <a href="logout.php" class="text-white text-decoration-none">Sign Out</a>
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

    <!-- CONTENT -->
    <div class="content">
        <div class="report-box">
            <h4>Reports</h4>
            <hr>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Subject :</label>
                    <select name="subject" class="report-select" required>
                        <option value="">SELECT SUBJECT</option>
                        <option value="MAN">MAN</option>
                        <option value="ETI">ETI</option>
                        <option value="SFT">SFT</option>
                        <option value="CSS">CSS</option>
                        <option value="MAD">MAD</option>
                        <option value="CPE">CPE</option>
                        <option value="NIS">NIS</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" name="generate" class="submit-btn">GENERATE REPORT</button>
                </div>
            </form>

        </div>
    </div>

</div>

</body>
</html>
