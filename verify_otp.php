<?php
session_start();

if(!isset($_SESSION['reset_email'])){
    header("Location: forgot_password.php");
    exit;
}

$error="";
$success="";
$otp_valid_time = 30; 


if(isset($_POST['verify'])){

    if(!isset($_SESSION['reset_otp']) || !isset($_SESSION['otp_time'])){
        $error = "OTP Expired! Please Resend OTP.";
    }

    else if(time() - $_SESSION['otp_time'] > $otp_valid_time){
        $error = "OTP Expired! Please Resend OTP.";
        unset($_SESSION['reset_otp']);
        unset($_SESSION['otp_time']);
    }

    else if($_POST['otp'] == $_SESSION['reset_otp']){

        unset($_SESSION['reset_otp']);
        unset($_SESSION['otp_time']);

        header("Location: reset_password.php");
        exit;
    }

    else{
        $error="Invalid OTP!";
    }
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
if(isset($_POST['resend'])){

    $newOtp = rand(100000,999999);

    $_SESSION['reset_otp'] = $newOtp;
    $_SESSION['otp_time'] = time();

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username='parnikamestri2026@gmail.com';
        $mail->Password='gxnf trxi uzex kwxk';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('parnikamestri2026@gmail.com','Student MIS');
        $mail->addAddress($_SESSION['reset_email']);

        $mail->isHTML(true);
        $mail->Subject = 'Your New OTP';
        $mail->Body    = "<h3>Your New OTP is: <b>$newOtp</b></h3>";

        $mail->send();

        $success = "New OTP Sent Successfully!";
    }
    catch(Exception $e){
        $error = "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}

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
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
    text-align:center;
}

.card h2{
    margin-bottom:10px;
    color:#333;
}

.subtitle{
    font-size:14px;
    color:#666;
    margin-bottom:20px;
}

.timer{
    font-size:14px;
    margin-bottom:15px;
    font-weight:600;
    color:#e74a3b;
}

.input-box{
    margin-bottom:20px;
}

.input-box input{
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #ccc;
    text-align:center;
    font-size:20px;
    letter-spacing:4px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:15px;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s;
}

.verify-btn{
    background:#4e73df;
    color:white;
}

.verify-btn:hover{
    background:#2e59d9;
}

.resend-btn{
    background:#858796;
    color:white;
}

.resend-btn:disabled{
    background:#ccc;
    cursor:not-allowed;
}

.message{
    margin-bottom:15px;
    font-size:14px;
    color:red;
}

.success{
    color:green;
}
</style>
</head>

<body>

<div class="card">
    <h2>Verify OTP</h2>
    <div class="subtitle">Enter the 6-digit code sent to your email</div>

    <?php if(!empty($error)): ?>
        <div class="message"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="timer" id="countdown"></div>

    <form method="post">
        <div class="input-box">
            <input type="text" name="otp" maxlength="6" placeholder="------" required>
        </div>

        <button type="submit" name="verify" class="verify-btn">
            Verify OTP
        </button>
    </form>

    <form method="post">
        <button type="submit" name="resend" id="resendBtn" class="resend-btn" disabled>
            Resend OTP
        </button>
    </form>

</div>

<script>
let timeLeft = 30;
const countdown = document.getElementById("countdown");
const resendBtn = document.getElementById("resendBtn");

resendBtn.disabled = true;

let timer = setInterval(function(){

    if(timeLeft <= 0){
        clearInterval(timer);
        countdown.innerHTML = "OTP Expired!";
        resendBtn.disabled = false;
    }
    else{
        countdown.innerHTML = "OTP expires in: " + timeLeft + " seconds";
    }

    timeLeft--;

},1000);
</script>

</body>
</html>