<?php
include "DB.php";
include "admin_auth.php";

$success = false;
$error = "";

if(isset($_POST['submit'])){

    $dept_name = mysqli_real_escape_string($conn, $_POST['dept_name']);
    $dept_code = mysqli_real_escape_string($conn, $_POST['dept_code']);

    $check = mysqli_query($conn,"SELECT * FROM departments 
                                 WHERE department_code='$dept_code'");

    if(mysqli_num_rows($check) > 0){
        $error = "Department Code already exists!";
    } else {

        $query = "INSERT INTO departments
                  (department_name, department_code, status)
                  VALUES ('$dept_name','$dept_code',1)";

        if(mysqli_query($conn,$query)){
            $success = true;
        } else {
            $error = "Insert Failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Department Registration</title>

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
    font-family:Segoe UI, Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}


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
    font-size: 22px;
    font-weight: bold;
}

.logout a{
    color:white;
    text-decoration:none;
    font-size:16px;
}


.main {
    display: flex;
    height: calc(100vh - 70px);
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

.content{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
}
.dept-card{
    width:420px;
    padding:30px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
    background:#fff;
}
h2{text-align:center;margin-bottom:25px;}
.form-group{margin-bottom:18px;}
label{
    display:inline-block;
    width:140px;
    font-weight:600;
}
input{
    width:220px;
    padding:6px;
    border:1px solid #aaa;
    border-radius:4px;
}
.btn-submit{
    display:block;
    margin:25px auto 0;
    padding:8px 30px;
    background:#5b7fa6;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:8px;
    cursor:pointer;
}
.btn-submit:hover{
    background:#4a6a8d;
}
.error{
    color:red;
    text-align:center;
}
.popup{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}
.popup-content{
    background:#fff;
    width:350px;
    padding:25px;
    text-align:center;
    border-radius:8px;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}
.popup-content button{
    padding:6px 20px;
    background:#5b7fa6;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
.logout{
    color:white;
    text-decoration:none;
    font-size:15px;
}

.logout:hover{
    opacity:0.8;
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
} 
</style>
</head>

<body>

<div class="header">
    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $username; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>

<div class="main">

<div class="sidebar">
    <a href="Admin_Dash_StudentList.php">STUDENT</a>
    <a href="faculty.php">FACULTY</a>
    <a href="admin_notification.php">NOTIFICATIONS</a>
    <a href="admin_announcement.php">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php" class="active">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php">PROGRAM REGISTRATION</a>
</div>

<div class="content">
<div class="dept-card">

<h2>Department Registration</h2>

<?php if($error!=""){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post">
    <div class="form-group">
        <label>Department Name:</label>
        <input type="text" name="dept_name" required>
    </div>

    <div class="form-group">
        <label>Department Code:</label>
        <input type="text" name="dept_code" required>
    </div>

    <button type="submit" name="submit" class="btn-submit">
        Register
    </button>
</form>

</div>
</div>

</div>


<div class="popup" id="popup">
    <div class="popup-content">
        <h3>Department Registered Successfully!</h3>
        <p>Data saved successfully.</p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>

<script>
<?php if($success){ ?>
document.getElementById("popup").style.display = "block";
<?php } ?>

function closePopup(){
    document.getElementById("popup").style.display = "none";
    window.location.href="Department_Registration.php";
}
</script>

</body>
</html>
