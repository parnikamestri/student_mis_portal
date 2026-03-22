<?php
include("DB.php");

$semesters = [];

$result = mysqli_query($conn,"
SELECT 
    s.semester_id,
    p.program_code,
    s.semester_number
FROM semester s
JOIN program p ON s.program_id = p.program_id
WHERE s.status='Active'
ORDER BY p.program_code, s.semester_number
");

while($row = mysqli_fetch_assoc($result)){
    $semesters[] = $row;
}
$programs = [];

$prog_result = mysqli_query($conn,"
SELECT program_id, program_name, program_code 
FROM program
WHERE status='Active'
ORDER BY program_name
");

while($row = mysqli_fetch_assoc($prog_result)){
    $programs[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Registration</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: "Segoe UI", Arial, sans-serif;
}

body{
    background:#f4f6f9;
}

.wrapper{
    width:100%;
    padding:40px 0;
}

.container{
    width:1000px;
    margin:auto;
    background:#ffffff;
    padding:35px 45px;
    border-radius:8px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.header{
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    margin-bottom:30px;
}

.header h2{
    font-size:22px;
    font-weight:600;
    color:#333;
}

.back-icon{
    position:absolute;
    left:0;
    text-decoration:none;
    font-size:18px;
    color:#444;
}

.form-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:20px 30px;
}

.full-width{
    grid-column: span 2;
}

label{
    font-size:14px;
    font-weight:600;
    margin-bottom:6px;
    display:block;
    color:#444;
}

input, select{
    width:100%;
    padding:8px 10px;
    border-radius:5px;
    border:1px solid #ccc;
    font-size:14px;
}

.button-section{
    text-align:right;
    margin-top:25px;
}

.submit-btn{
    display:block;
    margin:30px auto 0;
    padding:8px 35px;
    background:#5b7fa6;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:10px;
    cursor:pointer;
}

.submit-btn:hover{
    opacity:0.8;
}

@media(max-width:950px){
    .container{
        width:95%;
    }
    .form-grid{
        grid-template-columns:1fr;
    }
    .full-width{
        grid-column: span 1;
    }
}
</style>
</head>

<body>

<div class="wrapper">
<div class="container">

<div class="header">
    <a href="hod_dashboard.php" class="back-icon">&#8592;</a>
    <h2>Subject Registration (HOD)</h2>
</div>

<form method="post" action="subject_register.php">

<div class="form-grid">

<div class="full-width">
<label>Subject Name</label>
<input type="text" name="subject_name" required>
</div>

<div>
<label>Subject Code</label>
<input type="text" name="subject_code" required>
</div>

<div>
<label>Program</label>
<select name="program_id" required>
    <option value="">-- Select Program --</option>

    <?php foreach($programs as $row){ ?>
        <option value="<?= $row['program_id']; ?>">
            <?= $row['program_name']; ?> (<?= $row['program_code']; ?>)
        </option>
    <?php } ?>

</select>
</div>

<div>
<label>Semester</label>
<select name="semester_id" required>
    <option value="">-- Select --</option>

    <?php foreach($semesters as $row){ ?>
        <option value="<?= $row['semester_id']; ?>">
            <?= $row['program_code']; ?> - SEM <?= $row['semester_number']; ?>
        </option>
    <?php } ?>

</select>
</div>


<div>
<label>Course Category</label>
<input type="text" name="course_category" required>
</div>

<div>
<label>CL Hours</label>
<input type="number" name="cl_hours" value="0">
</div>

<div>
<label>TL Hours</label>
<input type="number" name="tl_hours" value="0">
</div>

<div>
<label>LL Hours</label>
<input type="number" name="ll_hours" value="0">
</div>

<div>
<label>IKS Hours</label>
<input type="number" name="iks_hours" value="0">
</div>

<div>
<label>SLH Hours</label>
<input type="number" name="slh_hours" value="0">
</div>

<div>
<label>NLH Hours</label>
<input type="number" name="nlh_hours" value="0">
</div>

<div>
<label>Credits</label>
<input type="number" name="credits" required>
</div>

<div>
<label>Paper Duration (Hours)</label>
<input type="number" name="paper_duration" value="3">
</div>

<div>
<label>Subject Type</label>
<select name="subject_type">
    <option>Theory</option>
    <option>Practical</option>
    <option>No</option>
    <option>Both</option>
</select>
</div>

<div>
<label>Total Marks</label>
<input type="number" name="total_marks">
</div>

<div>
<label>Passing Marks</label>
<input type="number" name="passing_marks">
</div>

<div>
<label>FA Theory Marks</label>
<input type="number" name="fa_th_marks">
</div>

<div>
<label>SA Theory Marks</label>
<input type="number" name="sa_th_marks">
</div>

<div>
<label>FA Practical Marks</label>
<input type="number" name="fa_pr_marks">
</div>

<div>
<label>SA Practical Marks</label>
<input type="number" name="sa_pr_marks">
</div>

<div>
<label>SLA Marks</label>
<input type="number" name="sla_marks">
</div>

<div>
<label>Theory Minimum Marks</label>
<input type="number" name="theory_min_marks">
</div>

<div>
<label>Practical Minimum Marks</label>
<input type="number" name="practical_min_marks">
</div>

<div>
<label>SLA Minimum Marks</label>
<input type="number" name="sla_min_marks">
</div>

<div>
<label>Exam Type</label>
<select name="exam_type">
    <option>Internal</option>
    <option>External</option>
    <option>Both</option>
</select>
</div>
<div class="full-width">
<label><b>Select Exams For This Subject</b></label><br><br>

<label><input type="checkbox" name="exam_names[]" value="SLA"> SLA</label><br>
<label><input type="checkbox" name="exam_names[]" value="Unit Test"> Unit Test</label><br>
<label><input type="checkbox" name="exam_names[]" value="Mid Exam"> Mid Exam</label><br>
<label><input type="checkbox" name="exam_names[]" value="Practical"> Practical</label>

</div>

</div>


</div>

<div class="button-section">
    <button type="submit" class="submit-btn">Register Subject</button>
</div>

</form>

</div>
</div>

</body>
</html>