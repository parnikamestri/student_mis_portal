<?php
include("DB.php");
include("faculty_auth.php");

$hodName = $name;
$dept_id = $_SESSION['dept_id'];



$semesters = [];

$q = mysqli_query($conn,"
SELECT 
s.semester_id,
s.semester_number
FROM semester s
JOIN program p ON s.program_id=p.program_id
WHERE p.dept_id='$dept_id'
AND s.status='Active'
ORDER BY s.semester_number
");

while($r=mysqli_fetch_assoc($q)){
$semesters[]=$r;
}



$faculties = [];

$f = mysqli_query($conn,"
SELECT faculty_id,name 
FROM faculty
WHERE dept_id='$dept_id'
AND status='Active'
");

while($r=mysqli_fetch_assoc($f)){
$faculties[]=$r;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Subject Faculty Assign</title>

<style>

body{
font-family:Segoe UI;
background:#f4f7f9;
margin:0;
}

.header{
height:70px;
background:#5b7fa6;
color:white;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 25px;
}

.main{
display:flex;
height:calc(100vh - 70px);
}

.sidebar{
width:250px;
background:#eef3f7;
}

.sidebar a{
display:block;
padding:18px;
text-decoration:none;
color:#333;
border-bottom:1px solid #ddd;
}

.sidebar a:hover{
background:#dde8f0;
}

.content{
flex:1;
padding:40px;
}

.card{
background:white;
padding:40px;
border-radius:8px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

select{
padding:8px 12px;
border-radius:20px;
border:1px solid #ccc;
width:220px;
}

table{
width:100%;
margin-top:25px;
border-collapse:collapse;
}

table td{
border:1px solid #ccc;
padding:20px;
}

.assign-btn{
padding:8px 20px;
background:#5b7fa6;
color:white;
border:none;
border-radius:20px;
cursor:pointer;
}

.hidden{
display:none;
}

</style>
</head>

<body>

<div class="header">
<h2><?php echo $hodName ?></h2>
<a href="Login_new.php" style="color:white;">Sign Out</a>
</div>

<div class="main">

<div class="sidebar">
<a href="faculty_attendance_select.php">ATTENDANCE</a>
        <a href="marks_entry.php">MARKS ENTRY</a>
        <a href="reports.php">REPORTS</a>
        <a href="notifications.php">NOTIFICTAIONS</a>
        <a href="class_wise_students.php">CLASS WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMNTS</a>
        <a href="sub_registration.php">SUBJECT REGISTRATION</a>
        <a href="Admin_Subject_Assign.php" class="active">SUBJECT FACULTY ASSIGN</a>
</div>

<div class="content">

<div class="card">

<label>Select Semester</label><br><br>

<select id="semester" onchange="loadSubjects()">

<option value="">Select Semester</option>

<?php
foreach($semesters as $sem){
?>

<option value="<?php echo $sem['semester_id'] ?>">
Semester <?php echo $sem['semester_number'] ?>
</option>

<?php } ?>

</select>


<br><br>

<div id="subjectDiv" class="hidden">

<label>Select Subject</label><br><br>

<select id="subject" onchange="loadSections()">

<option value="">Select Subject</option>

</select>

</div>


<div id="sectionDiv" class="hidden">

<h3 id="subjectTitle"></h3>

<table>

<tr id="practicalRow">

<td><b>PRACTICAL</b></td>

<td>

<select id="practicalFaculty">

<option value="">Select Faculty</option>

<?php
foreach($faculties as $f){
?>

<option value="<?php echo $f['faculty_id'] ?>">
<?php echo $f['name'] ?>
</option>

<?php } ?>

</select>

</td>

<td>

<button class="assign-btn" onclick="assignFaculty()">Assign</button>

</td>

</tr>


<tr id="theoryRow">

<td><b>THEORY</b></td>

<td>

<select id="theoryFaculty">

<option value="">Select Faculty</option>

<?php
foreach($faculties as $f){
?>

<option value="<?php echo $f['faculty_id'] ?>">
<?php echo $f['name'] ?>
</option>

<?php } ?>

</select>

</td>

<td>

<button class="assign-btn" onclick="assignFaculty()">Assign</button>

</td>

</tr>

</table>

</div>

</div>
</div>
</div>


<script>

function loadSubjects(){

let semester=document.getElementById("semester").value;

if(semester==""){
document.getElementById("subjectDiv").classList.add("hidden");
return;
}

fetch("get_sub_faculty.php?semester_id="+semester)

.then(res=>res.json())

.then(data=>{

let subject=document.getElementById("subject");

subject.innerHTML='<option value="">Select Subject</option>';

data.forEach(function(s){

subject.innerHTML+=`<option value="${s.subject_id}" data-type="${s.subject_type}">
${s.subject_name} (${s.subject_code})
</option>`;

});

document.getElementById("subjectDiv").classList.remove("hidden");

});

}



function loadSections(){

let subjectSelect=document.getElementById("subject");

let option=subjectSelect.options[subjectSelect.selectedIndex];

let type=option.getAttribute("data-type");

document.getElementById("subjectTitle").innerText="SUBJECT - "+option.text;

document.getElementById("sectionDiv").classList.remove("hidden");

if(type=="Theory"){

document.getElementById("practicalRow").style.display="none";
document.getElementById("theoryRow").style.display="";

}

else if(type=="Practical"){

document.getElementById("practicalRow").style.display="";
document.getElementById("theoryRow").style.display="none";

}

else{

document.getElementById("practicalRow").style.display="";
document.getElementById("theoryRow").style.display="";

}

}


function assignFaculty(){

let subject=document.getElementById("subject").value;

let theory=document.getElementById("theoryFaculty").value;
let practical=document.getElementById("practicalFaculty").value;

fetch("assign_subject_ajax.php",{

method:"POST",

headers:{"Content-Type":"application/x-www-form-urlencoded"},

body:`subject_id=${subject}&theory=${theory}&practical=${practical}`

})

.then(res=>res.text())

.then(data=>alert(data));

}

</script>

</body>
</html>