<?php
session_start();
include "DB.php";

$error = "";

if(isset($_POST['login'])){

$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = trim($_POST['password']);

$userFound = false;


/* ---------- ADMIN LOGIN ---------- */

$query = mysqli_query($conn,
"SELECT * FROM admin WHERE username='$username' AND status='Active'"
);

if(mysqli_num_rows($query)>0){

$user = mysqli_fetch_assoc($query);
$userFound = true;

if(hash("sha256",$password) === $user['password']){

$_SESSION['admin_id'] = $user['admin_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['admin_name'] = $user['full_name'];
$_SESSION['role'] = "admin";

header("Location: AdminDash.php");
exit;

}else{
$error="Invalid Password!";
}

}


/* ---------- STUDENT LOGIN ---------- */

if(!$userFound){

$query = mysqli_query($conn,
"SELECT * FROM students WHERE enrollment_id='$username' AND status='Active'"
);

if(mysqli_num_rows($query)>0){

$user = mysqli_fetch_assoc($query);
$userFound = true;

if(hash("sha256",$password) === $user['password']){

$_SESSION['student_id'] = $user['student_id'];
$_SESSION['username'] = $user['enrollment_id'];
$_SESSION['student_name'] = $user['student_name'];
$_SESSION['role'] = "student";

header("Location: student_dashboard.php");
exit;

}else{
$error="Invalid Password!";
}

}

}


/* ---------- FACULTY LOGIN ---------- */

if(!$userFound){

$query = mysqli_query($conn,
"SELECT * FROM faculty WHERE username='$username' AND status='Active'"
);

if(mysqli_num_rows($query)>0){

$user = mysqli_fetch_assoc($query);
$userFound = true;

if(password_verify($password,$user['password'])){

$_SESSION['user_id'] = $user['faculty_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['name'] = $user['name'];
$_SESSION['role'] = $user['role'];
$_SESSION['dept_id'] = $user['dept_id'];

if($user['role']=="HOD"){
header("Location: hod_dashboard.php");
}else{
header("Location: faculty_dashboard.php");
}

exit;

}else{
$error="Invalid Password!";
}

}

}

if(!$userFound){

$officeQuery = mysqli_query($conn,
"SELECT * FROM office_staff 
WHERE username='$username' 
AND status='Active'"
);

if(mysqli_num_rows($officeQuery) > 0){

$user = mysqli_fetch_assoc($officeQuery);
$userFound = true;

if(hash("sha256",$password) === $user['password']){

$_SESSION['user_id'] = $user['emp_no'];
$_SESSION['username'] = $user['username'];
$_SESSION['name'] = $user['name'];
$_SESSION['role'] = $user['role'];

header("Location: offic_dashboard.php");
exit;

}else{
$error="Invalid Password!";
}

}

}
/* ---------- USER NOT FOUND ---------- */

if(!$userFound){
$error="Invalid Username!";
}

}
?>
<style>
body{
    margin:0;
    font-family: "Segoe UI", Arial, sans-serif;
    background:linear-gradient(135deg, #eef2f6, #dde7f1);
    background:#eef2f6;
}


.wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}


.card{
    width:80vw;             
    max-width:9000px;       
    min-height:720px;        
    background:#fff;
    display:flex;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    border-radius:10px;
    overflow:hidden;
}


.left{
    width:45%;
    padding:40px;
    text-align:center;

    display:flex;
    flex-direction:column;
    justify-content:center;   
}

.brand{
    display:flex;
    flex-direction:column;
    align-items:center;   
    margin-bottom:30px;
}

.brand img{
    width:70px;
    margin-bottom:10px;
}

.brand h2{
    text-align:center;
}

.left form{
    text-align:left;
    max-width:360px;
    margin:0 auto;
}


.left img{
    width:100px;
}

.left h2{
    font-size:17px;
    margin:15px 0 30px;
    color:#1a365d;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:18px;
    border-radius:4px;
    border:1px solid #cbd5e0;
    font-size:14px;
}

input:focus{
    outline:none;
    border-color:#2b6cb0;
}

.forgot{
    font-size:13px;
    color:#2b6cb0;
    text-decoration:none;
}


button{
    margin-top:25px;
    width:100%;
    padding:12px;
    background:#2b6cb0;
    color:#fff;
    border:none;
    border-radius:4px;
    font-size:15px;
    cursor:pointer;
}

button:hover{
    background:#1e4f8a;
}


.right{
    width:55%;
    background:#f7fafc;
    border-left:1px solid #e2e8f0;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.right img{
    width:240px;
}

.right h1{
    margin-top:20px;
    font-size:22px;
    color:#1a365d;
}

.right h3{
    margin-top:5px;
    font-weight:normal;
}


@media(max-width:900px){
    .card{
        flex-direction:column;
        width:90%;
    }
    .left,.right{
        width:100%;
    }
}
</style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="left">
            <div class="brand">
                <img src="college image\gpr_logo.jpeg" alt="College Logo">
                <h2>GOVERNMENT POLYTECHNIC RATNAGIRI</h2>
            </div>
            <form method="post">
               <?php if(!empty($error)){ ?>
    <p id="errorMsg" style="color:red;text-align:center;margin-bottom:15px;">
        <?php echo $error; ?>
    </p>
<?php } ?>
                <input type="text" name="username" placeholder="Username or Enrollment ID" required>
                <input type="password" name="password" placeholder="Password" required>
                <a class="forgot" href="Forgot_Password.php">Forgot Password?</a>
                <button type="submit" name="login">LOGIN</button>
            </form>
        </div>
        <div class="right">
            <img src="college image\gpr_logo.jpeg">
            <h1>शासकीय तंत्रनिकेतन</h1>
            <h3>रत्नागिरी</h3>
        </div>
    </div>
</div>
<script>setTimeout(function(){
    var msg = document.getElementById("errorMsg");
    if(msg){
        msg.style.display = "none";
    }
}, 5000);</script>
</body>
</html>