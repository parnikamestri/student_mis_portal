<?php
session_start();
include("DB.php");


use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';



if(isset($_GET['id']) && isset($_GET['action'])){

    $student_id = intval($_GET['id']);
    $action = $_GET['action'];

    if($action == "approve"){
        $status = "Approved";
    } elseif($action == "reject"){
        $status = "Rejected";
    } else {
        die("Invalid Action");
    }


    $stmt = $conn->prepare("UPDATE students SET status=? WHERE student_id=?");
    $stmt->bind_param("si", $status, $student_id);
    $stmt->execute();

    $result = mysqli_query($conn, "SELECT email, student_name FROM students WHERE student_id='$student_id'");
    $student = mysqli_fetch_assoc($result);

    if($student){

        $mail = new PHPMailer(true);

        try{
          
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username = 'parnikamestri2026@gmail.com';
$mail->Password = 'gxnf trxi uzex kwxk';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('parnikamestri2026@gmail.com', 'Student MIS Portal');
            $mail->addAddress($student['email'], $student['student_name']);

            $mail->isHTML(true);
            $mail->Subject = "Admission Status Update";
            $mail->Body    = "
                Hello {$student['student_name']}, <br><br>
                Your admission status has been <b>$status</b>.<br><br>
                Thank you.<br>
                Student MIS Portal
            ";

            $mail->send();
        }
        catch(Exception $e){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    header("Location: view_student_application.php?id=".$student_id);
    exit();
}


if(isset($_POST['send_correction'])){

    $student_id = intval($_POST['student_id']);
    $message = $_POST['correction_message'];


    $stmt = $conn->prepare("UPDATE students SET status='Correction Required' WHERE student_id=?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();


    $result = mysqli_query($conn, "SELECT email, student_name FROM students WHERE student_id='$student_id'");
    $student = mysqli_fetch_assoc($result);

    if($student){

        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
           $mail->Username = 'parnikamestri2026@gmail.com';
$mail->Password = 'gxnf trxi uzex kwxk';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('parnikamestri2026@gmail.com', 'Student MIS Portal');
            $mail->addAddress($student['email'], $student['student_name']);

            $mail->isHTML(true);
            $mail->Subject = "Correction Required in Admission Form";
            $mail->Body    = "
                Hello {$student['student_name']}, <br><br>
                Please correct the following details:<br><br>
                <b>$message</b><br><br>
                Thank you.<br>
                Student MIS Portal
            ";

            $mail->send();
        }
        catch(Exception $e){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    header("Location: view_student_application.php?id=".$student_id);
    exit();
}
?>