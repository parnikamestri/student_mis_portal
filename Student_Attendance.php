<?php
$student_name = "TRUSHNA SOSHTE";

$subjects = [
    ["name"=>"NIS", "theory"=>22, "theory_total"=>30, "practical"=>22, "practical_total"=>30],
    ["name"=>"SFT", "theory"=>30, "theory_total"=>30, "practical"=>30, "practical_total"=>30],
    ["name"=>"CSS", "theory"=>22, "theory_total"=>30, "practical"=>22, "practical_total"=>30],
    ["name"=>"MAD", "theory"=>22, "theory_total"=>30, "practical"=>22, "practical_total"=>30],
];
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance Dashboard</title>

<style>
:root{
    --primary:#5b7fa6;
    --primary-dark:#3d5a73;
    --bg:#f4f7f9;
    --border:#d6e2ea;
    --text:#2c3e50;
}

/* COMMON */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, Arial, sans-serif;
}
body{
    background:var(--bg);
    color:var(--text);
}

/* HEADER (Same as First File) */
.header {
    height: 70px;
    background-color: #5b7fa6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
}
.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}
.profile-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    color: #5b7fa6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
.header-title {
    font-size: 26px;
    font-weight: bold;
}
.signout a{
    font-size:16px;
    color:white;              /* Make text white */
    text-decoration:none;     /* Remove underline */
    font-weight:500;
    transition:0.3s;
}

.signout a:hover{
    text-decoration:underline;   /* Optional hover effect */
    opacity:0.8;
}

/* MAIN */
.main {
    display: flex;
    height: calc(100vh - 70px);
}

/* SIDEBAR (Same as First File) */
.sidebar{
    width:260px;
    background:#eef3f7;
    border-right:1px solid var(--border);
    padding-top:20px;
}

.sidebar h3{
    padding:16px 22px;
    font-size:14px;
    font-weight:600;
    border-bottom:1px solid #dbe6ed;
    color:var(--text);
}

.sidebar hr{
    display:none;
}
.sidebar a{
    display:block;
    padding:18px 22px;
    border-bottom:1px solid #dbe6ed;
    text-decoration:none;
    color:var(--text);
    font-size:14px;
    font-weight:600;
    transition:0.25s;
}
.sidebar a:hover{
    background:#dde8f0;
    padding-left:28px;
}
.sidebar a.active{
    background:#dde8f0;
    border-left:4px solid var(--primary);
}


/* CONTENT */
.content{
    flex:1;
    padding:35px;
}

.title{
    margin-bottom:20px;
}

/* ATTENDANCE CARD */
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

.percent-badge{
    font-size:13px;
    font-weight:bold;
    color:var(--primary);
}

.sub-info{
    display:flex;
    gap:20px;
    font-size:13px;
    color:#555;
    margin-bottom:8px;
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
    transition:width 0.5s ease;
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
.extra-details p{
    margin:4px 0;
}
</style>
</head>

<body>

<div class="header">
    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $student_name; ?></div>
    </div>
    <div class="signout">
        <a href="Login_new.php">⏻ Sign Out</a>
    </div>
</div>
<div class="main">

<div class="sidebar">
    <a href="#">STUDENT</a>
    <a href="#">FACULTY</a>
    <a href="#" class="active">ATTENDANCE</a>
    <a href="#">APPLICATION</a>
    <a href="#">ANNOUNCEMENT</a>
    <a href="#">USER & ROLES</a>
</div>

<div class="content">
    <h2 class="title">ATTENDANCE</h2>

<?php foreach($subjects as $sub): 
    $total_obtained = $sub['theory'] + $sub['practical'];
    $total_classes = $sub['theory_total'] + $sub['practical_total'];
    $percentage = round(($total_obtained/$total_classes)*100);
?>

<div class="card" onclick="toggleDetails(this)">

    <div class="card-header">
        <div class="subject-title">
            <?php echo strtoupper($sub['name']); ?>
        </div>
        <div class="percent-badge">
            <?php echo $percentage; ?>%
        </div>
    </div>

    <div class="sub-info">
        <span>Theory: <?php echo $sub['theory']."/".$sub['theory_total']; ?></span>
        <span>Practical: <?php echo $sub['practical']."/".$sub['practical_total']; ?></span>
    </div>

    <div class="progress-bar">
        <div class="progress" style="width: <?php echo $percentage; ?>%"></div>
    </div>

    <div class="extra-details">
        <p><strong>Total Lectures:</strong> <?php echo $total_classes; ?></p>
        <p><strong>Present:</strong> <?php echo $total_obtained; ?></p>
        <p><strong>Absent:</strong> <?php echo $total_classes - $total_obtained; ?></p>
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