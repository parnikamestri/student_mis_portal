<?php
include("student_auth.php");
include("DB.php");

$currentSemester = $_SESSION['semester_id'] ?? "Not Assigned";

$query = mysqli_query($conn,"
SELECT 
    s.subject_name,
    ar.attendance_type,
    ar.total_lectures,
    ar.attended_lectures,
    ar.attendance_percentage
FROM attendance_report ar
JOIN subject s ON ar.subject_id = s.subject_id
WHERE ar.student_id = '$studentId'
ORDER BY s.subject_name
");

$subjects = [];

while($row = mysqli_fetch_assoc($query)){

    $sub = $row['subject_name'];

    if(!isset($subjects[$sub])){
        $subjects[$sub] = [
            "theory"=>0,
            "theory_total"=>0,
            "theory_percent"=>0,
            "practical"=>0,
            "practical_total"=>0,
            "practical_percent"=>0
        ];
    }

    if($row['attendance_type']=="Theory"){
        $subjects[$sub]['theory']=$row['attended_lectures'];
        $subjects[$sub]['theory_total']=$row['total_lectures'];
        $subjects[$sub]['theory_percent']=$row['attendance_percentage'];
    }

    if($row['attendance_type']=="Practical"){
        $subjects[$sub]['practical']=$row['attended_lectures'];
        $subjects[$sub]['practical_total']=$row['total_lectures'];
        $subjects[$sub]['practical_percent']=$row['attendance_percentage'];
    }
}

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
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance Dashboard</title>

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

.dropdown{
    position:relative;
}

.dropdown-btn{
    background:#274b73;
    color:#fff;
    border:none;
    padding:6px 14px;
    border-radius:14px;
    cursor:pointer;
    font-size:13px;
}

.dropdown-content{
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

.dropdown-content div{
    padding:10px;
    cursor:pointer;
    font-size:13px;
    color:#000;
}

.dropdown-content div:hover{
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

.content{
    flex:1;
    padding:35px;
}
.title{
    margin-bottom:20px;
}


.card{
    background:white;
    padding:15px 18px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.06);
    cursor:pointer;
    border-left:5px solid var(--primary);
    transition:0.3s;
}
.card:hover{
    background:#f0f5fa;
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:8px;
}

.subject-title{
    font-size:15px;
    font-weight:600;
}

.percent-section{
    text-align:right;
    font-size:12px;
    font-weight:bold;
    color:var(--primary);
}

.red{
    color:var(--danger);
}

.progress-bar{
    background:#dbe6f0;
    height:8px;
    border-radius:20px;
    overflow:hidden;
}

.progress{
    height:100%;
    background:var(--primary);
    border-radius:20px;
}

.extra-details{
    margin-top:10px;
    background:#ffffff;
    padding:10px;
    border-radius:8px;
    display:none;
    border:1px solid #dbe2e8;
    font-size:13px;
}
.section-title{
    margin-top:8px;
    font-weight:bold;
    color:var(--primary-dark);
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
        <div class="user-circle">👤</div>
        <strong><?php echo $username; ?></strong>
    </div>

    <div class="header-right">

       <div class="dropdown">
    <button class="dropdown-btn" onclick="toggleDropdown()">
        <span id="selectedOption">
            Semester <?php echo $currentSemester; ?>
        </span> ▼
    </button>

    <div class="dropdown-content" id="dropdownMenu">
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
        <a href="attendance_student.php" class="active">ATTENDANCE</a>
        <a href="Student_Dash_Marks.php">MARKS</a>
        <a href="application.php">APPLICATION</a>
        <a href="student_notification.php">NOTIFICATIONS</a>
    </div>


<div class="content">
<h2 class="title">ATTENDANCE</h2>

<?php foreach($subjects as $name=>$sub): 

$total_obtained = $sub['theory'] + $sub['practical'];
$total_classes = $sub['theory_total'] + $sub['practical_total'];

$overall = ($total_classes > 0) 
    ? round(($total_obtained/$total_classes)*100) 
    : 0;

$colorClass = ($overall < 75) ? "red" : "";
?>

<div class="card" onclick="toggleDetails(this)">

    <div class="card-header">
        <div class="subject-title">
            <?php echo strtoupper($name); ?>
        </div>

        <div class="percent-section <?php echo $colorClass; ?>">
            Overall: <?php echo $overall; ?>% <br>
            T: <?php echo $sub['theory_percent']; ?>% | 
            P: <?php echo $sub['practical_percent']; ?>%
        </div>
    </div>

    <div class="progress-bar">
        <div class="progress" style="width: <?php echo $overall; ?>%"></div>
    </div>

    <div class="extra-details">

        <div class="section-title">Theory Details</div>
        <p>Total Theory Lectures: <?php echo $sub['theory_total']; ?></p>
        <p>Present: <?php echo $sub['theory']; ?></p>
        <p>Absent: <?php echo $sub['theory_total'] - $sub['theory']; ?></p>

        <div class="section-title">Practical Details</div>
        <p>Total Practicals: <?php echo $sub['practical_total']; ?></p>
        <p>Present: <?php echo $sub['practical']; ?></p>
        <p>Absent: <?php echo $sub['practical_total'] - $sub['practical']; ?></p>

    </div>

</div>

<?php endforeach; ?>

</div>
</div>

<script>
function toggleDetails(card) {
    let all = document.querySelectorAll(".extra-details");
    let current = card.querySelector(".extra-details");

    all.forEach(d => {
        if(d !== current){
            d.style.display = "none";
        }
    });

    current.style.display =
        current.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>