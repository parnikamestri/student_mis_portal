<?php
include("DB.php");

$semester_id = $_POST['semester_id'] ?? '';
$subject_id  = $_POST['subject_id'] ?? '';
$attendance_type = $_POST['attendance_type'] ?? '';

date_default_timezone_set("Asia/Kolkata");

$attendanceDateDB = date("Y-m-d");
$attendanceDate   = date("d-m-Y");
$attendanceTime   = date("h:i A");

$students = [];
$isSubmitted = false;
$semInfo = [];
$subjectInfo = [];

/* ================= FETCH CLASS + SUBJECT INFO ================= */

if($semester_id != '' && $subject_id != ''){

    $semQuery = mysqli_query($conn,"
        SELECT p.program_code, s.semester_number
        FROM semester s
        JOIN program p ON s.program_id = p.program_id
        WHERE s.semester_id='$semester_id'
    ");

    if($semQuery){
        $semInfo = mysqli_fetch_assoc($semQuery);
    }

    $subQuery = mysqli_query($conn,"
        SELECT subject_name 
        FROM subject
        WHERE subject_id='$subject_id'
    ");

    if($subQuery){
        $subjectInfo = mysqli_fetch_assoc($subQuery);
    }
}

/* ================= FETCH STUDENTS ================= */

$student_query = mysqli_query($conn,"
    SELECT * 
    FROM students
    WHERE semester_id='$semester_id'
    AND status='Active'
");

if(!$student_query){
    die("Student Query Error: " . mysqli_error($conn));
}

while($row = mysqli_fetch_assoc($student_query)){
    $students[] = $row;
}

/* ================= SAVE ATTENDANCE ================= */

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['att'])){

    foreach($_POST['att'] as $student_id => $status){

        $check = mysqli_query($conn,"
            SELECT * FROM attendance_report
            WHERE student_id='$student_id'
            AND subject_id='$subject_id'
            AND semester_id='$semester_id'
            AND attendance_type='$attendance_type'
        ");

        if(mysqli_num_rows($check) > 0){

            $row = mysqli_fetch_assoc($check);

            $total = $row['total_lectures'] + 1;
            $attended = $row['attended_lectures'];

            if($status == "Present"){
                $attended++;
            }

            $percentage = ($attended / $total) * 100;
            $attendance_status = ($percentage >= 75) ? "Good" : "Low";

            mysqli_query($conn,"
                UPDATE attendance_report
                SET total_lectures='$total',
                    attended_lectures='$attended',
                    attendance_percentage='$percentage',
                    attendance_status='$attendance_status'
                WHERE student_id='$student_id'
                AND subject_id='$subject_id'
                AND semester_id='$semester_id'
                AND attendance_type='$attendance_type'
            ");

        } else {

            $total = 1;
            $attended = ($status == "Present") ? 1 : 0;
            $percentage = ($attended / $total) * 100;
            $attendance_status = ($percentage >= 75) ? "Good" : "Low";

            mysqli_query($conn,"
                INSERT INTO attendance_report
                (student_id, subject_id, semester_id,
                 total_lectures, attended_lectures,
                 attendance_percentage, attendance_status,
                 academic_year, attendance_type)
                VALUES
                ('$student_id','$subject_id','$semester_id',
                 '$total','$attended',
                 '$percentage','$attendance_status',
                 '".date("Y")."',
                 '$attendance_type')
            ");
        }
    }

    $isSubmitted = true;
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $attendance_type ?> Attendance Sheet</title>

<?php if($isSubmitted): ?>
<script>
setTimeout(function(){
    window.location.href = "faculty_dashboard.php";
},3000);
</script>
<?php endif; ?>

<style>
:root{
    --primary:#4f6d8a;
    --bg:#f4f7f9;
    --card:#ffffff;
    --border:#d6e2ea;
    --text:#2c3e50;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI, Arial;}
body{background:var(--bg);color:var(--text);}
.container{max-width:1100px;margin:40px auto;background:#fff;border-radius:12px;padding:25px;}
.info-bar{display:flex;justify-content:space-between;margin-bottom:20px;}
.badge{background:#e6f1f4;padding:12px 20px;border-radius:6px;font-weight:600;text-align:center;}
.success{background:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;}
th,td{padding:14px;border:1px solid #999;text-align:center;}
th{background:#f4f6f8;}
td.name{text-align:left;}
.attendance{display:flex;justify-content:center;gap:40px;}
.footer-btns{display:flex;justify-content:space-between;margin-top:25px;}
.footer-btns button{background:#5b7fa6;color:#fff;border:none;padding:12px 35px;border-radius:25px;}
.back-btn{
    position:absolute;top:18px;left:18px;
    width:38px;height:38px;border:1px solid #d0d7de;
    border-radius:8px;background:#fff;
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
}
.back-btn svg{width:18px;height:18px;stroke:#333;}
.back-btn:hover{background:#f4f6f8;}
</style>
</head>
<body>

<a href="faculty_attendance_select.php" class="back-btn" title="Back">
<svg viewBox="0 0 24 24" fill="none" stroke-width="2">
<path d="M15 18l-6-6 6-6"/>
</svg>
</a>

<div class="container">

<?php if($isSubmitted): ?>
<div class="success">
✔ Attendance saved on <?= $attendanceDate ?> at <?= $attendanceTime ?><br>
Redirecting to dashboard...
</div>
<?php endif; ?>

<div class="info-bar">

<div class="badge">
Class<br>
<b><?= $semInfo['program_code'] ?? '' ?> - SEM <?= $semInfo['semester_number'] ?? '' ?></b>
</div>

<div class="badge">
Subject<br>
<b><?= $subjectInfo['subject_name'] ?? '' ?></b>
</div>

<div class="badge">
Attendance Type<br>
<b><?= $attendance_type ?></b>
</div>

<div class="badge">
Date<br>
<b><?= $attendanceDate ?></b><br><?= $attendanceTime ?>
</div>

</div>

<form method="post">
<input type="hidden" name="semester_id" value="<?= $semester_id ?>">
<input type="hidden" name="subject_id" value="<?= $subject_id ?>">
<input type="hidden" name="attendance_type" value="<?= $attendance_type ?>">

<table>
<tr>
<th>Roll No</th>
<th>Student Name</th>
<th>Attendance</th>
</tr>

<?php foreach($students as $s): ?>
<tr>
<td><?= $s['enrollment_id'] ?></td>
<td class="name"><?= $s['student_name'] ?></td>
<td>
<div class="attendance">
<label>
<input type="radio" name="att[<?= $s['student_id'] ?>]" value="Present" required> Present
</label>
<label>
<input type="radio" name="att[<?= $s['student_id'] ?>]" value="Absent"> Absent
</label>
</div>
</td>
</tr>
<?php endforeach; ?>

</table>

<div class="footer-btns">
<button type="submit">Save Attendance</button>
<button type="reset">Reset</button>
</div>

</form>
</div>
</body>
</html>