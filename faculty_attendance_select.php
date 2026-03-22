<?php

include("DB.php");
include("faculty_auth.php");

$fac = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT dept_id 
FROM faculty 
WHERE faculty_id='$faculty_id'
"));

$department_id = $fac['dept_id'];


$query = mysqli_query($conn,"
SELECT 
s.semester_id,
p.program_code,
s.semester_number
FROM semester s
JOIN program p ON s.program_id=p.program_id
WHERE s.status='Active'
AND p.dept_id='$department_id'
ORDER BY p.program_code,s.semester_number
");

$classes = [];

while($row=mysqli_fetch_assoc($query)){
$classes[]=$row;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Attendance</title>

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
    padding:25px;
    background:#f8f9fa;
    display:flex;
    align-items:center;
    justify-content:center;
}

.card{
background:var(--card);
padding:40px 50px;
max-width:850px;
width:100%;
border-radius:10px;
border:1px solid var(--border);
box-shadow:0 6px 20px rgba(0,0,0,0.08);
transition:0.3s;
}

.card:hover{
box-shadow:0 10px 28px rgba(0,0,0,0.12);
transform:translateY(-2px);
}

.card h2{
margin-bottom:30px;
font-size:22px;
color:var(--primary-dark);
border-bottom:2px solid var(--border);
padding-bottom:10px;
}
.form-row{
display:flex;
align-items:center;
gap:25px;
margin-bottom:25px;
}

.form-row label{
width:160px;
font-weight:600;
color:var(--text);
}

select{
width:320px;
padding:10px 15px;
border-radius:25px;
border:1px solid var(--border);
background:white;
outline:none;
transition:0.25s;
}

select:focus{
border-color:var(--primary);
box-shadow:0 0 0 3px rgba(79,109,138,0.15);
}

.btn-submit{
background:linear-gradient(135deg,#5b7fa6,#4f6d8a);
color:white;
border:none;
padding:12px 55px;
border-radius:30px;
font-size:15px;
font-weight:600;
cursor:pointer;
transition:0.3s;
}

.btn-submit:hover{
transform:translateY(-2px);
box-shadow:0 6px 15px rgba(0,0,0,0.2);
}

.submit-wrap{
text-align:center;
margin-top:35px;
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

            <div class="sidebar">
                    <a href="faculty_attendance_select.php" class="active">ATTENDANCE</a>
                    <a href="marks_entry.php" >MARKS ENTRY</a>
                    <a href="reports.php">REPORTS</a>
                    <a href="notifications.php">NOTIFICATIONS</a>
                    <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
                    <a href="announcement.php">ANNOUNCEMENTS</a>
            </div>

        </div>


        <div class="content">

                <div class="card">

                        <h2>ATTENDANCE</h2>

                        <form action="attendance.php" method="post">


                            <div class="form-row">

                                <label>Select Class</label>

                                <select name="semester_id" id="semesterSelect" required>

                                <option value="">-- Select --</option>

                                <?php foreach($classes as $row){ ?>

                                <option value="<?= $row['semester_id']; ?>">

                                <?= $row['program_code']; ?> - SEM <?= $row['semester_number']; ?>

                                </option>

                                <?php } ?>

                                </select>

                            </div>


                            <div class="form-row">

                                <label>Select Subject</label>

                                <select name="subject_id" id="subjectSelect" required>

                                <option value="">-- Select Semester First --</option>

                                </select>

                            </div>

                            <div class="form-row" id="typeRow" style="display:none;"> <label>Attendance Type</label> <select name="attendance_type" id="attendanceType"> <option value="">-- Select --</option> </select> </div>
                            <div class="submit-wrap">

                                <button class="btn-submit">SUBMIT</button>

                            </div>

                    </form>

                </div>

            </div>

        </div>
</div>

<script>

document.getElementById("semesterSelect").addEventListener("change", function(){

    let sem = this.value;

    let xhr = new XMLHttpRequest();

    xhr.open("GET","get_subject.php?semester_id="+sem,true);

    xhr.onload = function(){
        document.getElementById("subjectSelect").innerHTML = this.responseText;
    }

    xhr.send();

});
document.getElementById("subjectSelect").addEventListener("change",function(){ let selected=this.options[this.selectedIndex]; let type=selected.getAttribute("data-type"); let typeRow=document.getElementById("typeRow"); let typeSelect=document.getElementById("attendanceType"); typeSelect.innerHTML='<option value="">-- Select --</option>'; if(type=="Theory"){ typeSelect.innerHTML+='<option value="Theory">Theory</option>'; typeRow.style.display="flex"; } else if(type=="Practical"){ typeSelect.innerHTML+='<option value="Practical">Practical</option>'; typeRow.style.display="flex"; } else if(type=="Both"){ typeSelect.innerHTML+='<option value="Theory">Theory</option>'; typeSelect.innerHTML+='<option value="Practical">Practical</option>'; typeRow.style.display="flex"; } else{ typeRow.style.display="none"; } });

</script>

</body>

</html>