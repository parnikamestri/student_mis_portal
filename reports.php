<?php

include "DB.php";
include "faculty_auth.php";

$fac = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT dept_id 
FROM faculty 
WHERE faculty_id='$faculty_id'
"));

$dept_id = $fac['dept_id'];



$sem_q = mysqli_query($conn,"
SELECT DISTINCT s.semester_id, s.semester_number
FROM semester s
JOIN program p ON s.program_id=p.program_id
WHERE p.dept_id='$dept_id'
AND s.status='Active'
ORDER BY s.semester_number
");

while($row=mysqli_fetch_assoc($sem_q)){
$semesters[]=$row;
}

/* FORM SUBMIT */
if(isset($_POST['submit'])){

    if(empty($_POST['subject_id'])){
        die("Please select subject");
    }

    $_SESSION['report_type'] = $_POST['report_type'];
    $_SESSION['semester_id'] = $_POST['semester_id'] ?? null;
    $_SESSION['subject_id']  = $_POST['subject_id'];
    $_SESSION['exam_id']     = $_POST['exam_id'] ?? null;

    header("Location: report_display.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Faculty Reports</title>

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
    flex-shrink:0;
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
    padding:40px;
    min-width:300px;
    display:flex;
    justify-content:center;
    align-items:center;
}
.report-box{
    width:560px;
    background:var(--card);
    padding:35px 30px;
    border-radius:12px;
    border:1px solid var(--border);
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}

.report-box h4{
    font-size:20px;
    margin-bottom:10px;
}

.report-box hr{
    margin-bottom:20px;
    border:0;
    border-top:1px solid var(--border);
}

.report-box label{
    display:block;
    font-size:14px;
    margin-bottom:6px;
    color:var(--text);
    font-weight:600;
}

.report-select{
    width:100%;
    padding:10px 14px;
    border-radius:20px;
    border:1px solid #ccd6dd;
    background:white;
    font-size:14px;
    margin-bottom:15px;
}

.report-select:focus{
    outline:none;
    border-color:var(--accent);
}

.submit-btn{
   display:block;
    margin:35px auto 0;
    padding:12px 60px;
    background:linear-gradient(135deg,#5b7fa6,#4f6d8a);
    color:white;
    border:none;
    border-radius:30px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}


.submit-btn:hover{
    background:linear-gradient(135deg,#4f6d8a,#3d5a73);
    transform:translateY(-1px);
}
.submit-wrap{
    text-align:center;
    margin-top:35px;
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
        <a href="reports.php" class="active">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMENTS</a>
    </div>


    <div class="content">

        <div class="report-box">

            <h4>Generate Report</h4>
            <hr>

            <form method="post" id="reportForm">

            
            <div class="mb-3">
                <label class="fw-bold">Report Type</label>

                <select name="report_type" id="report_type" class="report-select" required>
                    <option value="">Select Type</option>
                    <option value="attendance">Attendance</option>
                    <option value="marks">Marks</option>
                </select>
            </div>


            <div class="mb-3" id="semesterDiv" style="display:none">
                <label class="fw-bold">Semester</label>

                <select name="semester_id" id="semester_id" class="report-select">
                    <option value="">Select Semester</option>

                    <?php foreach($semesters as $sem){ ?>

                    <option value="<?= $sem['semester_id'] ?>">
                        Semester <?= $sem['semester_number'] ?>
                    </option>

                    <?php } ?>
                </select>
            </div>


            <div class="mb-3" id="subjectDiv" style="display:none">
                <label class="fw-bold">Subject</label>

                <select name="subject_id" id="subject_id" class="report-select">
                    <option value="">Select Subject</option>
                </select>
            </div>


            <div class="mb-3" id="examDiv" style="display:none">
                <label class="fw-bold">Exam</label>

                <select name="exam_id" id="exam_id" class="report-select">
                    <option value="">Select Exam</option>
                </select>
            </div>

            <button class="submit-btn" name="submit">Generate Report</button>

            </form>

        </div>

    </div>

</div>
<script>



document.getElementById('report_type').addEventListener('change',function(){

const type=this.value;

const semDiv=document.getElementById('semesterDiv');
const subjDiv=document.getElementById('subjectDiv');
const examDiv=document.getElementById('examDiv');

if(type==="attendance"){

semDiv.style.display="block";
subjDiv.style.display="none";
examDiv.style.display="none";

}

else if(type==="marks"){

semDiv.style.display="block";
subjDiv.style.display="none";
examDiv.style.display="none";

}

else{

semDiv.style.display="none";
subjDiv.style.display="none";
examDiv.style.display="none";

}

});





document.getElementById('semester_id').addEventListener('change',function(){

const semId=this.value;
const facultyId=<?= $faculty_id ?>;
const type=document.getElementById('report_type').value;

if(!semId) return;

fetch(`fetch_subjects.php?semester_id=${semId}&faculty_id=${facultyId}&type=${type}`)

.then(res=>res.json())

.then(data=>{

let options='<option value="">Select Subject</option>';

data.forEach(sub=>{

options+=`<option value="${sub.subject_id}">${sub.subject_name}</option>`;

});

document.getElementById('subject_id').innerHTML=options;

document.getElementById('subjectDiv').style.display='block';

document.getElementById('examDiv').style.display='none';

});

});





document.getElementById('subject_id').addEventListener('change',function(){

const subject=this.value;
const type=document.getElementById('report_type').value;

if(type!=="marks") return;

fetch(`fetch_exams.php?subject_id=${subject}`)

.then(res=>res.json())

.then(data=>{

let options='<option value="">Select Exam</option>';

data.forEach(exam=>{

options+=`<option value="${exam.exam_id}">${exam.exam_name}</option>`;

});

document.getElementById('exam_id').innerHTML=options;

document.getElementById('examDiv').style.display='block';

});

});

</script>

</body>
</html>