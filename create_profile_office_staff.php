<?php
include "DB.php";   
include "admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Create Office Staff Profile</title>

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

.form-box{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:25px 30px;
    border:1px solid #cfd6dd;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
}

h2{text-align:center;color:#2c4e6e;}

hr{border-top:2px solid #5f84a9;}

.section-title{
    background:#5f84a9;
    color:white;
    padding:7px 12px;
    margin:20px 0 12px;
}

.form-row{
    display:flex;
    gap:20px;
    margin-bottom:14px;
}

.form-row label{
    width:220px;
    font-weight:600;
}

.form-row input,
.form-row select{
    flex:1;
    padding:8px;
}

.submit-btn{
    background:#5f84a9;
    color:white;
    padding:10px 30px;
    border:none;
    border-radius:20px;
}

.center{
    text-align:center;
    margin-top:25px;
}

</style>
</head>

<body>

<div class="form-box">

<h2>Create Office Staff Profile</h2>
<hr>

<form action="save_office_staff.php" method="post" enctype="multipart/form-data">

<div class="section-title">Basic Details</div>

<div class="form-row">
<label>Employee No</label>
<input type="text" name="emp_no">
</div>

<div class="form-row">
<label>Name</label>
<input type="text" name="name">
</div>

<div class="form-row">
<label>Age</label>
<input type="number" name="age">
</div>

<div class="form-row">
<label>Gender</label>
<select name="gender">
<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
</div>

<div class="form-row">
<label>Date Of Birth</label>
<input type="date" name="dob">
</div>

<div class="form-row">
<label>Department</label>
<select name="dept_id">

<option value="">-- Select Department --</option>

<?php

$query = "SELECT dept_id, department_name 
          FROM departments 
          WHERE status=1";

$result = mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{
echo "<option value='{$row['dept_id']}'>
{$row['department_name']}
</option>";
}

?>

</select>
</div>

<div class="section-title">Contact Details</div>

<div class="form-row">
<label>Mobile Number</label>
<input type="text" name="mobile">
</div>

<div class="form-row">
<label>Email</label>
<input type="email" name="email">
</div>

<div class="form-row">
<label>Address</label>
<input type="text" name="address">
</div>

<div class="form-row">
<label>Photo</label>
<input type="file" name="photo">
</div>

<div class="section-title">Job Details</div>

<div class="form-row">
<label>Designation</label>
<input type="text" name="designation">
</div>

<div class="form-row">
<label>Qualification</label>
<input type="text" name="qualification">
</div>

<div class="form-row">
<label>Joining Date</label>
<input type="date" name="joining_date">
</div>

<div class="form-row">
<label>Role</label>
<select name="role">

<option value="">-- Select Role --</option>
<option value="Office Staff">Office Staff</option>
<option value="Clerk">Clerk</option>
<option value="Accountant">Accountant</option>
<option value="Admin Staff">Admin Staff</option>

</select>
</div>
<div class="center">
<button class="submit-btn" type="submit" name="submit">Submit</button>
</div>
</form>

</div>
</body>
</html>