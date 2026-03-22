<?php
// Handle form submit
if(isset($_POST['submit'])){
    
    $class   = $_POST['class'];
    $subject = $_POST['subject'];
    $exam    = $_POST['exam'];

    // You can redirect to marks entry page later
    // header("Location: marks_entry.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Profile - Marks Entry</title>

<style>
body{
    margin:0;
    font-family: Arial, sans-serif;
    background:url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1') no-repeat center/cover;
}
.header{
    background:#5f84a9;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.container{
    display:flex;
}
.sidebar{
    width:240px;
    background:rgba(230,240,243,0.95);
    min-height:100vh;
}
.sidebar a{
    display:block;
    padding:18px 25px;
    text-decoration:none;
    color:#000;
    border-bottom:1px solid #c0c0c0;
}
.sidebar a.active,
.sidebar a:hover{
    background:#cfd6d8;
    font-weight:bold;
}
.content{
    flex:1;
    padding:40px;
}
.branch{
    font-size:22px;
    font-weight:bold;
    margin-bottom:15px;
}
.form-box{
    width:500px;
    background:rgba(120,190,200,0.75);
    padding:40px;
    border-radius:8px;
}
.row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}
label{
    font-size:20px;
    font-weight:bold;
}
select{
    width:220px;
    padding:10px 15px;
    border-radius:25px;
    border:none;
    font-size:16px;
}
.submit-btn{
    display:block;
    margin:40px auto 0;
    padding:14px 60px;
    background:#0a8be0;
    color:white;
    border:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
}
.submit-btn:hover{
    background:#056bb2;
}
</style>
</head>

<body>

<div class="header">
    <h2>Faculty Profile</h2>
    <div>Sign Out</div>
</div>

<div class="container">

    <div class="sidebar">
        <a href="#">ATTENDANCE</a>
        <a href="#" class="active">MARKS ENTRY</a>
        <a href="#">REPORTS</a>
        <a href="#">NOTIFICATIONS</a>
        <a href="#">CLASS-WISE STUDENT LIST</a>
        <a href="#">ANNOUNCEMENTS</a>
    </div>

    <div class="content">
        <div class="branch">Branch : CO</div>

        <form method="post">
            <div class="form-box">

                <div class="row">
                    <label>Class</label>
                    <select name="class">
                        <option>CO1K</option>
                        <option>CO2K</option>
                        <option>CO3K</option>
                    </select>
                </div>

                <div class="row">
                    <label>Subject</label>
                    <select name="subject">
                        <option>BMS</option>
                        <option>CN</option>
                        <option>OS</option>
                    </select>
                </div>

                <div class="row">
                    <label>Exam</label>
                    <select name="exam">
                        <option>SLA</option>
                        <option>UNIT TEST</option>
                        <option>MID-EXAM</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    SUBMIT
                </button>

            </div>
        </form>
    </div>

</div>

</body>
</html>
