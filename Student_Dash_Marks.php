<?php
include("DB.php");
include("student_auth.php");
$currentSemester = $_SESSION['semester_id'] ?? "Not Assigned";

$result = mysqli_query($conn,"
    SELECT class 
    FROM students 
    WHERE student_id='$studentId'
");

$result = mysqli_query($conn,"
    SELECT s.semester_name
    FROM students st
    JOIN semester s ON st.semester_id = s.semester_id
    WHERE st.student_id='$studentId'
");

if($result && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $currentSemester = $row['semester_name'];
} else {
    $currentSemester = "Not Assigned";
}
$stuQuery = mysqli_query($conn,"
SELECT student_name, semester_id
FROM students
WHERE student_id='$studentId'
");

$stu = mysqli_fetch_assoc($stuQuery);

$semester_id = $stu['semester_id'];

/* SUBJECTS OF STUDENT SEM */
$subQuery = mysqli_query($conn,"
SELECT subject_id,subject_name,subject_code,
fa_th_marks,sa_th_marks,sla_marks,fa_pr_marks
FROM subject
WHERE semester_id='$semester_id'
AND status='Active'
");

$subjects=[];

while($sub=mysqli_fetch_assoc($subQuery)){

$subject_id=$sub['subject_id'];

/* SUBJECT EXAMS */
$examQuery=mysqli_query($conn,"
SELECT exam_id,exam_name
FROM exam
WHERE subject_id='$subject_id'
");

$exams=[];

while($exam=mysqli_fetch_assoc($examQuery)){

$exam_id=$exam['exam_id'];
$exam_name=$exam['exam_name'];

/* TOTAL MARKS LOGIC */
$total=0;

if(stripos($exam_name,"Unit")!==false)
$total=$sub['fa_th_marks'];

elseif(stripos($exam_name,"Mid")!==false)
$total=$sub['sa_th_marks'];

elseif(stripos($exam_name,"SLA")!==false)
$total=$sub['sla_marks'];

elseif(stripos($exam_name,"Practical")!==false)
$total=$sub['fa_pr_marks'];


/* OBTAINED MARKS */
$marksQuery=mysqli_query($conn,"
SELECT marks_obtained
FROM marks_report
WHERE student_id='$studentId'
AND exam_id='$exam_id'
");

$marks=mysqli_fetch_assoc($marksQuery);

$obtained=$marks['marks_obtained'] ?? "-";

$exams[]=[
"name"=>$exam_name,
"obtained"=>$obtained,
"total"=>$total
];

}

$subjects[]=[
"name"=>$sub['subject_name'],
"code"=>$sub['subject_code'],
"exams"=>$exams
];

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Marks</title>

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

.header-right{
    display:flex;
    align-items:center;
    gap:20px;
}

.dropdown-s{
    position:relative;
}

.dropdown-btn-s{
    background:#274b73;
    color:#fff;
    border:none;
    padding:6px 14px;
    border-radius:14px;
    cursor:pointer;
    font-size:13px;
}

.dropdown-content-s{
    display:none;
    position:absolute;
    right:0;
    top:35px;
    background:#fff;
    min-width:180px;
    border-radius:6px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
    z-index:10;
}

.dropdown-content-s div{
    padding:10px;
    cursor:pointer;
    font-size:13px;
    color:#000;
}

.dropdown-content-s div:hover{
    background:#eaf5f8;
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


.logout-btn{
    display:inline-block;
    background: linear-gradient(135deg,#e53935,#c62828);
    color:white;
    padding:8px 18px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition:all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg,#c62828,#b71c1c);
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.25);
}

.content{
flex:1;
padding:25px;
}


.card{
background:var(--card);
padding:30px;
border-radius:10px;
border:1px solid var(--border);
}



.dropdown-wrapper{
display:flex;
justify-content:center;
margin-bottom:30px;
}

.dropdown{
position:relative;
}

.dropdown-btn{
background:#edf2f7;
border:1px solid var(--border);
padding:10px 22px;
border-radius:20px;
cursor:pointer;
font-weight:600;
color:#34495e;
}

.dropdown-content{
display:none;
position:absolute;
top:45px;
background:white;
width:220px;
border-radius:8px;
border:1px solid var(--border);
}

.dropdown-content div{
padding:10px 14px;
cursor:pointer;
font-size:14px;
}

.dropdown-content div:hover{
background:#f2f6fa;
}



.subject-title{
font-size:18px;
font-weight:600;
margin-bottom:18px;
color:#2c3e50;
}



table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:6px;
overflow:hidden;
}

th{
background:#f3f6fa;
padding:12px;
font-weight:600;
font-size:14px;
color:#34495e;
border-bottom:1px solid var(--border);
}

td{
padding:12px;
font-size:14px;
border-bottom:1px solid var(--border);
text-align:center;
}

tr:last-child td{
border-bottom:none;
}

tr:hover{
background:#fafcfe;
}

</style>
</head>

<body>

<div class="header">

    <div class="header-left">
        <div class="user-circle">👤</div>
        <strong><?php echo $username; ?></strong>
    </div>

    <div class="header-right">

       <div class="dropdown-s">
    <button class="dropdown-btn-s" onclick="toggleDropdown()">
        <span id="selectedOption">
            Semester <?php echo $currentSemester; ?>
        </span> ▼
    </button>

    <div class="dropdown-content-s" id="dropdownMenu">
        <div>Semester <?php echo $currentSemester; ?></div>
    </div>
</div>

        <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>

    </div>
</div>

<div class="container">


<div class="sidebar">
<a href="Student_Dash_Profile.php">PROFILE</a>
<a href="#">ATTENDANCE</a>
<a class="active">MARKS</a>
<a href="application.php">APPLICATION</a>
<a href="student_notification.php">NOTIFICATIONS</a>
</div>

<div class="content">



<div class="dropdown-wrapper">
<div class="dropdown">

<button class="dropdown-btn" onclick="toggleDropdown()">
SELECT SUBJECT ▼
</button>

<div class="dropdown-content" id="subjectMenu">

<?php foreach($subjects as $sub){ ?>

<div onclick='selectSubject(
<?php echo json_encode($sub["name"]); ?>,
<?php echo json_encode($sub["code"]); ?>,
<?php echo json_encode($sub["exams"]); ?>
)'>

<?php echo $sub["code"]; ?>

</div>

<?php } ?>

</div>
</div>
</div>

<div id="subjectTitle" class="subject-title" style="display:none"></div>

<table id="marksTable" style="display:none">

<tr>
<th>ASSESSMENT TYPE</th>
<th>MARKS OBTAINED</th>
<th>TOTAL MARKS</th>
</tr>

<tbody id="examBody"></tbody>

</table>

</div>
</div>

<script>

function toggleDropdown(){

let d=document.getElementById("subjectMenu");

d.style.display=d.style.display==="block"?"none":"block";

}

function selectSubject(name,code,exams){

document.getElementById("subjectTitle").innerText=
`SUBJECT - ${name} (${code})`;

document.getElementById("subjectTitle").style.display="block";

document.getElementById("marksTable").style.display="table";

document.getElementById("subjectMenu").style.display="none";

let tbody=document.getElementById("examBody");

tbody.innerHTML="";

exams.forEach(exam=>{

tbody.innerHTML+=`

<tr>
<td>${exam.name}</td>
<td>${exam.obtained}</td>
<td>${exam.total}</td>
</tr>

`;

});

}

document.addEventListener("click",e=>{
if(!e.target.closest(".dropdown")){
document.getElementById("subjectMenu").style.display="none";
}
});

</script>

</body>
</html>