<?php
include "DB.php";

if(isset($_POST['submit'])){


    $emp_no         = "EMP".rand(1000,9999);
    $name           = $_POST['name'];
    $age            = $_POST['age'];
    $gender         = $_POST['gender'];
    $dob            = $_POST['dob'];
    $address        = $_POST['address'];

    
    $mobile         = $_POST['mobile'];
    $email          = $_POST['email'];

    
    $dept_id        = $_POST['dept_id'];   
    $designation    = $_POST['designation'];
    $qualification  = $_POST['qualification'];
    $specialization = $_POST['specialization'];
    $experience     = $_POST['experience'];
    $joining_date   = $_POST['joining_date'];
    $role = $_POST['role'];

    $username = $email;
    $password = password_hash("faculty@123", PASSWORD_DEFAULT);
   
    $status   = "Active";


    $photo = "";
    if($_FILES['photo']['name'] != ""){
        $photo = time()."_".$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
    }


    $sql = "INSERT INTO faculty 
    (emp_no, name, age, gender, dob, address, photo, email, mobile, dept_id,
     designation, qualification, specialization, experience_year, joining_date,
     username, password, role, status)
    VALUES
    ('$emp_no','$name','$age','$gender','$dob','$address','$photo','$email','$mobile','$dept_id',
     '$designation','$qualification','$specialization','$experience','$joining_date',
     '$username','$password','$role','$status')";

    if(mysqli_query($conn,$sql)){
        echo "<script>alert('Faculty Profile Created Successfully');</script>";
        echo "<script>window.location.href='create_profile.php';</script>";
    }else{
        echo "Error : " . mysqli_error($conn);
    }
}
?>