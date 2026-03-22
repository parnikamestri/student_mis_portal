<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "DB.php";

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if(isset($_POST['post'])){

    $title     = mysqli_real_escape_string($conn,$_POST['title']);
    $message   = mysqli_real_escape_string($conn,$_POST['message']);
    $audience  = $_POST['audience'];
    $dept      = $_POST['dept_id'];
    $priority  = $_POST['priority'];
    $expiry    = $_POST['expiry'];
    $status    = $_POST['status'];

    
    $sql = "INSERT INTO announcements_admin
            (title,message,audience,dept_id,priority,expiry_date,status)
            VALUES
            ('$title','$message','$audience','$dept','$priority','$expiry','$status')";

    if(!mysqli_query($conn,$sql)){
        die("Insert Error: ".mysqli_error($conn));
    }

   
    $emails = [];

    if($audience == "Students"){
        $q = "SELECT email FROM students
              WHERE dept_id='$dept'";
    }
    elseif($audience == "Faculty"){
        $q = "SELECT email FROM faculty
              WHERE dept_id='$dept'";
    }
    else{
        $q = "
        SELECT email FROM students WHERE dept_id='$dept'
        UNION
        SELECT email FROM faculty WHERE dept_id='$dept'
        ";
    }

    $res = mysqli_query($conn,$q);
    while($row = mysqli_fetch_assoc($res)){
        $emails[] = $row['email'];
    }

    
    if(count($emails) > 0){

        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'parnikamestri2026@gmail.com';   
            $mail->Password   = 'gxnf trxi uzex kwxk';     
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('parnikamestri2026@gmail.com','College Admin');
            $mail->isHTML(true);
            $mail->Subject = "New Announcement: $title";

            $mail->Body = "
                <h3>$title</h3>
                <p>$message</p>
                <hr>
                <b>Priority:</b> $priority <br>
                <b>Expiry:</b> $expiry
            ";

            foreach($emails as $email){
                $mail->addAddress($email);
            }

            $mail->send();

        }catch(Exception $e){
            echo "Email Error: {$mail->ErrorInfo}";
        }
    }

    header("Location: admin_announcement.php");
    exit;
}
?>