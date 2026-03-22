
<?php
session_start();
include "DB.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$message="";

if(isset($_POST['send_otp'])){

    if(isset($_POST['email']) && !empty($_POST['email'])){

        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $otp = rand(100000,999999);
        $role="";

        // ADMIN
        if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM admin WHERE email='$email'"))>0){
            $role="admin";
        }

        // STUDENT
        elseif(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students WHERE email='$email'"))>0){
            $role="student";
        }

        // FACULTY
        elseif(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM faculty WHERE email='$email'"))>0){
            $role="faculty";
        }

        else{
            $message="Email not registered!";
        }

        if($role!=""){

            $_SESSION['reset_email']=$email;
            $_SESSION['reset_role']=$role;
            $_SESSION['reset_otp']=$otp;
            $_SESSION['otp_time']=time();

            $mail = new PHPMailer(true);

            try{
                $mail->isSMTP();
                $mail->Host='smtp.gmail.com';
                $mail->SMTPAuth=true;
                $mail->Username='';
                $mail->Password='';
                $mail->SMTPSecure='tls';
                $mail->Port=587;

                $mail->setFrom('','Student MIS');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject='OTP for Password Reset';
                $mail->Body="<h3>Your OTP is: <b>$otp</b></h3>";

                $mail->send();

                header("Location: verify_otp.php");
                exit;

            }catch(Exception $e){
                $message="Mailer Error: ".$mail->ErrorInfo;
            }
        }
    }
    else{
        $message="Please enter email!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
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
    width:380px;
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

.input-box label{
    font-size:14px;
    color:#555;
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

.footer-text{
    margin-top:20px;
    font-size:13px;
}

.footer-text a{
    text-decoration:none;
    color:#4e73df;
}
</style>

</head>
<body>

<div class="card">
    <h2>Forgot Password</h2>

    <?php if($message!="") echo "<div class='message'>$message</div>"; ?>

    <form method="post">
        <div class="input-box">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <button type="submit" name="send_otp">Send OTP</button>
    </form>

    <div class="footer-text">
        Remember your password? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>
