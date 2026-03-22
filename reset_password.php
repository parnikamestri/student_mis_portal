<?php
session_start();
include "DB.php";

$error = "";


if(!isset($_SESSION['reset_email'])){
    header("Location: forgot_password.php");
    exit;
}

if(isset($_POST['reset'])){

    
    $newpass = $_POST['new_password'];
    $confirmpass = $_POST['confirm_password'];
    $role = $_SESSION['reset_role'];
    $email = $_SESSION['reset_email'];

 
    if($newpass !== $confirmpass){
        $error = "New Password and Confirm Password must be same!";
    }
    else{

        if($role == "faculty"){
          
            $hashed = password_hash($newpass, PASSWORD_DEFAULT);
            mysqli_query($conn,"UPDATE faculty SET password='$hashed' WHERE username='$email'");
        }
        elseif($role == "admin"){
           
            $hashed = hash("sha256", $newpass);
            mysqli_query($conn,"UPDATE admin SET password='$hashed' WHERE email='$email'");
        }
        else{
        
            $hashed = hash("sha256", $newpass);
            mysqli_query($conn,"UPDATE students SET password='$hashed' WHERE email='$email'");
        }

        session_destroy();

        echo "<script>
        alert('Password Reset Successful');
        window.location='login.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f4f6f9;
}

.card{
    background:#fff;
    width:400px;
    padding:40px;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    text-align:center;
}

.card h2{
    margin-bottom:25px;
    color:#333;
}

.input-box{
    margin-bottom:20px;
    text-align:left;
}

.input-box input{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    transition:0.3s;
}

.input-box input:focus{
    border-color:#4e73df;
    box-shadow:0 0 5px rgba(78,115,223,0.5);
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#4e73df;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#2e59d9;
}

.message{
    margin-bottom:15px;
    font-size:14px;
    color:red;
}


.error-border{
    border:2px solid red !important;
}

.success-border{
    border:2px solid green !important;
}

.small-text{
    font-size:13px;
    margin-top:5px;
}
</style>

</head>
<body>

<div class="card">
    <h2>Reset Password</h2>

    <?php if(!empty($error)): ?>
        <div class="message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" onsubmit="return validateForm()">

        <div class="input-box">
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
        </div>

        <div class="input-box">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            <div id="matchMessage" class="small-text"></div>
        </div>

        <button type="submit" name="reset">Reset Password</button>
    </form>
</div>

<script>
const newPass = document.getElementById("new_password");
const confirmPass = document.getElementById("confirm_password");
const message = document.getElementById("matchMessage");

confirmPass.addEventListener("keyup", function() {

    if(confirmPass.value === ""){
        confirmPass.classList.remove("error-border","success-border");
        message.innerHTML = "";
        return;
    }

    if(newPass.value === confirmPass.value){
        confirmPass.classList.remove("error-border");
        confirmPass.classList.add("success-border");
        message.style.color = "green";
        message.innerHTML = "Passwords match ✔";
    } else {
        confirmPass.classList.remove("success-border");
        confirmPass.classList.add("error-border");
        message.style.color = "red";
        message.innerHTML = "Passwords do not match ";
    }
});


function validateForm(){
    if(newPass.value !== confirmPass.value){
        confirmPass.classList.add("error-border");
        message.style.color = "red";
        message.innerHTML = "Passwords do not match";
        return false;
    }
    return true;
}
</script>

</body>
</html>