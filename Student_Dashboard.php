<?php
include "student_auth.php";
include "DB.php";


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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>

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

.content {
    flex: 1;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.content img {
    width: 92%;
    height: 92%;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 0 12px rgba(0,0,0,0.2);
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
        <a href="attendance_student.php">ATTENDANCE</a>
        <a href="Student_Dash_Marks.php">MARKS</a>
        <a href="application.php">APPLICATION</a>
        <a href="student_notification.php">NOTIFICATIONS</a>
    </div>

    <div class="content">
        <img src="https://content3.jdmagicbox.com/comp/ratnagiri/d1/9999p2352.2352.181113155857.v3d1/catalogue/government-polytechnic-abhyudhya-nagar-ratnagiri-colleges-lJLf5AnjcD.jpg">
    </div>

</div>

<script>
function toggleDropdown() {
    document.getElementById("dropdownMenu").style.display =
        document.getElementById("dropdownMenu").style.display === "block"
        ? "none" : "block";
}

document.addEventListener("click", function(event) {
    const dropdown = document.querySelector(".dropdown");
    if (!dropdown.contains(event.target)) {
        document.getElementById("dropdownMenu").style.display = "none";
    }
});
</script>

</body>
</html>