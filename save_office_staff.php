<?php

include "DB.php";


if(isset($_POST['submit']))
{

$emp_no      = $_POST['emp_no'];
$name        = $_POST['name'];
$age         = $_POST['age'];
$gender      = $_POST['gender'];
$dob         = $_POST['dob'];
$dept_id     = $_POST['dept_id'];

$mobile      = $_POST['mobile'];
$email       = $_POST['email'];
$address     = $_POST['address'];

$designation = $_POST['designation'];
$qualification = $_POST['qualification'];
$joining_date  = $_POST['joining_date'];

$role        = $_POST['role'];
$status   = "Active";

$username = $email; 
$password = hash("sha256", "office@123");





$photo = "";

if($_FILES['photo']['name'] != "")
{

$filename = $_FILES['photo']['name'];
$tempname = $_FILES['photo']['tmp_name'];

$folder = "uploads/staff/".$filename;

move_uploaded_file($tempname,$folder);

$photo = $filename;

}


/* INSERT QUERY */

$query = "INSERT INTO office_staff
(
emp_no,
name,
age,
gender,
dob,
dept_id,
mobile,
email,
address,
photo,
designation,
qualification,
joining_date,
username,
password,
role,
status
)

VALUES
(
'$emp_no',
'$name',
'$age',
'$gender',
'$dob',
'$dept_id',
'$mobile',
'$email',
'$address',
'$photo',
'$designation',
'$qualification',
'$joining_date',
'$username',
'$password',
'$role',
'$status'
)";

$result = mysqli_query($conn,$query);

if($result)
{
echo "<script>
alert('Office Staff Profile Created Successfully');
window.location='AdminDash.php';
</script>";
}
else
{
echo "Error : ".mysqli_error($conn);
}

}
?>