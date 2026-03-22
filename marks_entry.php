<?php
include("DB.php");
include("faculty_auth.php");
/* ===============================
// FETCH CLASSES (Semester + Program)
================================= */
/* Faculty Department */
$fac = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT dept_id 
FROM faculty 
WHERE faculty_id='$faculty_id'
"));

$dept_id = $fac['dept_id'];

/* Classes of faculty department */

$query = mysqli_query($conn,"
SELECT 
s.semester_id,
s.semester_number,
s.program_id,
p.program_code
FROM semester s
JOIN program p ON s.program_id = p.program_id
WHERE s.status='Active'
AND p.dept_id='$dept_id'
ORDER BY p.program_code, s.semester_number
");
$classes = [];
while($row = mysqli_fetch_assoc($query)){
    $classes[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Profile - Marks Entry</title>

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

/* ===== HEADER ===== */

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
    padding:40px;
    min-width:300px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.branch{
    display:inline-block;
    background:linear-gradient(135deg,#5b7fa6,#4f6d8a);
    color:white;
    font-size:14px;
    font-weight:600;
    padding:8px 18px;
    border-radius:20px;
    margin-bottom:400px;
    letter-spacing:0.5px;
    box-shadow:0 3px 8px rgba(0,0,0,0.15);
}

/* CARD */

.form-box{
    width:100%;
    max-width:520px;
    background:white;
    padding:40px 45px;
    border-radius:10px;
    border:1px solid #e2e8f0;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.form-box:hover{
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
    transform:translateY(-2px);
}

/* FORM ROW */

.row{
   display:flex;
    align-items:center;
    gap:25px;
    margin-bottom:25px;
}

/* LABEL */

label{
    width:160px;
    font-weight:600;
    color:var(--text);
}

/* SELECT */

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

/* BUTTON */

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
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
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
.logout{
    color:white;
    text-decoration:none;
    font-size:15px;
}

.logout:hover{
    opacity:0.8;
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
        <a href="marks_entry.php" class="active">MARKS ENTRY</a>
        <a href="reports.php">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php">ANNOUNCEMENTS</a>
    </div>

    <div class="content">
        <div class="branch">Branch : CO</div>

        <form id="marksForm">
            <div class="form-box">

                <div class="row">
                   <label for="semester">Select Class</label>
                    <select name="semester_id" id="semester" required>
                        <option value="">-- Select --</option>
                        <?php foreach($classes as $row){ ?>
                            <option value="<?= $row['semester_id']; ?>" data-program-id="<?= $row['program_id']; ?>">
                                <?= $row['program_code']; ?> - SEM <?= $row['semester_number']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="row">
                   <label for="subject">Select Subject</label>
                    <select name="subject_id" id="subject" required>
                        <option value="">-- Select --</option>
                        <!-- Subjects will load dynamically -->
                    </select>
                </div>

                <div class="row">
                    <label for="exam">Exam</label>
                    <select name="exam_id" id="exam" required>
                        <option value="">-- Select --</option>
                        <!-- Exams will load dynamically -->
                    </select>
                </div>

                <button type="submit" id="goBtn" class="submit-btn">SUBMIT</button>

            </div>
        </form>

    </div>

</div>

<script>
// Select elements
const semesterSelect = document.getElementById('semester');
const subjectSelect = document.getElementById('subject');
const examSelect = document.getElementById('exam');

// Load subjects based on selected class
semesterSelect.addEventListener('change', function() {
    const semester_id = semesterSelect.value;
    const program_id  = semesterSelect.selectedOptions[0]?.dataset.programId;

    if(!semester_id) {
        subjectSelect.innerHTML = '<option value="">-- Select --</option>';
        examSelect.innerHTML = '<option value="">-- Select --</option>';
        return;
    }

    fetch(`get_subjects.php?semester_id=${semester_id}&program_id=${program_id}`)
        .then(res => res.json())
        .then(data => {
            subjectSelect.innerHTML = '<option value="">-- Select --</option>';
            data.forEach(subject => {
                const opt = document.createElement('option');
                opt.value = subject.subject_id;
                opt.textContent = subject.subject_name;
                opt.dataset.type = subject.subject_type;
                subjectSelect.appendChild(opt);
            });
            examSelect.innerHTML = '<option value="">-- Select --</option>'; // reset exams
        })
        .catch(err => console.error('Error loading subjects:', err));
});

// Load exams based on selected subject
function loadExams(){
    const subject_id = subjectSelect.value;
    const semester_id = semesterSelect.value;
    const program_id = semesterSelect.selectedOptions[0]?.dataset.programId;

    if(!subject_id || !semester_id){
        examSelect.innerHTML = '<option value="">-- Select --</option>';
        return;
    }

    fetch(`get_exams.php?subject_id=${subject_id}&semester_id=${semester_id}&program_id=${program_id}`)
        .then(res => res.json())
        .then(data => {

            examSelect.innerHTML = '<option value="">-- Select --</option>';

            let unitTestAdded = false; // prevent duplicate Unit Test

            data.forEach(exam => {

                let examName = exam.exam_name;

                // If Unit Test 1 or Unit Test 2 → show only "Unit Test"
                if(examName.includes("Unit Test")){

                    if(unitTestAdded) return;

                    const opt = document.createElement('option');
                    opt.value = exam.exam_id;
                    opt.textContent = "Unit Test";
                    examSelect.appendChild(opt);

                    unitTestAdded = true;

                }else{

                    const opt = document.createElement('option');
                    opt.value = exam.exam_id;
                    opt.textContent = exam.exam_name;
                    examSelect.appendChild(opt);

                }

            });

        })
        .catch(err => console.error('Error loading exams:', err));
}

// Attach event to subject change
subjectSelect.addEventListener('change', loadExams);

// Form submit / redirect
document.getElementById('marksForm').addEventListener('submit', function(e){
    e.preventDefault();

    const semester = semesterSelect.value;
    const subject  = subjectSelect.value;
    const exam     = examSelect.value;

    if(!semester || !subject || !exam){
        alert('Please select Class, Subject and Exam');
        return;
    }

    const examName = examSelect.selectedOptions[0].textContent.toUpperCase();

    if(examName.includes('SLA')){
        window.location = `SLA.php?semester=${semester}&subject=${subject}`;
    } else if(examName.includes('UNIT')){
        window.location = `UnitTest.php?semester=${semester}&subject=${subject}`;
    } else if(examName.includes('MID')){
        window.location = `mid_exam_marks.php?semester=${semester}&subject=${subject}`;
    } else if(examName.includes('PRACTICAL')){
        window.location = `practical_exam.php?semester=${semester}&subject=${subject}`;
    } else {
        alert('Invalid exam selected: ' + examName);
    }
});
</script>

</body>
</html>