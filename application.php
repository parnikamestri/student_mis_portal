<?php
include "student_auth.php";
include "DB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Application Form For Admission</title>

<style>
body{
    font-family:"Segoe UI",Arial,sans-serif;
    background:#edf1f5;
    margin:0;
    padding:25px;
}
.container{
    max-width:950px;
    margin:auto;
    background:#fff;
    padding:25px 30px;
    border:1px solid #cfd6dd;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
}
h2,h3{
    text-align:center;
    margin:5px 0;
}
h2{color:#2c4e6e;}
h3{font-weight:normal;color:#555;}
.admission-year{
    text-align:center;
    font-weight:600;
    color:#2c4e6e;
    margin-top:6px;
}
hr{
    border:none;
    border-top:2px solid #5f84a9;
    margin:15px 0 20px;
}
label{
    font-size:14px;
    font-weight:600;
}
input,textarea,select{
    width:100%;
    padding:8px 10px;
    margin:6px 0 14px;
    border:1px solid #bfc7cf;
    border-radius:3px;
    font-size:14px;
}
.row{
    display:flex;
    gap:20px;
}
.row div{flex:1;}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
table th,table td{
    border:1px solid #bfc7cf;
    padding:8px;
    text-align:center;
}
table th{
    background:#f2f6fa;
}
.section-title{
    background:#5f84a9;
    color:white;
    padding:7px 12px;
    margin:20px 0 12px;
}
.btn{
    background:#5f84a9;
    color:white;
    border:none;
    padding:10px 25px;
    border-radius:20px;
    cursor:pointer;
}
.btn:hover{background:#4a6f91;}
.center{text-align:center;margin-top:25px;}
</style>
</head>

<body>

<div class="container">

<h2>Application Form For Admission</h2>
<h3>Government Polytechnic</h3>
<div class="admission-year" id="admissionYear"></div>
<hr>

<form action="save_student.php" method="post">

 
<div class="section-title">Basic Details</div>

<label>Course / Branch</label>
<select name="dept_id" required>
    <option value="">-- Select Department --</option>

    <?php
    include "DB.php";

    $query = "SELECT dept_id, department_name 
              FROM departments 
              WHERE status = 1";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['dept_id']}'>
                {$row['department_name']}
              </option>";
    }
    ?>
</select>



<label>Enrollment Number</label>
<input type="text" name="enrollment_no" placeholder="Enter Enrollment Number" required>

<div class="row">
<div>
<label>Full Name</label>
<input type="text" name="full_name" required>
</div>
<br>
<br>
<div>
<label>Date of Birth</label>
<input type="date" name="dob" required>
</div>
<br>
<br>
<div>
    <label>Mobile No</label>
<input type="phone number" name="phone_no" required>
</div>
<br>
<br>
<div>
    <label>Email ID</label>
<input type="email" name="email_id" required>
</div>
</div>


<div class="row">
<div>
<label>Gender</label>
<select name="gender" required>
    <option value="">-- Select --</option>
    <option>Male</option>
    <option>Female</option>
    <option>Other</option>
</select>
</div>

<div>
<label>Blood Group</label>
<select name="blood_group" required>
    <option value="">-- Select --</option>
    <option>A+</option>
    <option>A-</option>
    <option>B+</option>
    <option>B-</option>
    <option>AB+</option>
    <option>AB-</option>
    <option>O+</option>
    <option>O-</option>
</select>
</div>
</div>

<label>Caste / Sub-Caste</label>
<input list="casteList" name="caste">
<datalist id="casteList">
<option value="Open">
<option value="SC">
<option value="ST">
<option value="OBC">
<option value="VJNT">
<option value="SBC">
<option value="SEBC">
</datalist>

<!-- ADDITIONAL DETAILS -->
<div class="section-title">Additional Information</div>

<div class="row">
<div>
<label>Father's Occupation</label>
<input type="text" name="father_occupation">
</div>
<br>
<br>
<div>
<label>Annual Income</label>
<input type="text" name="annual_income">
</div>
</div>

<div class="row">
<div>
<label>Hostel Required?</label>
<select name="hostel_required">
<option>No</option>
<option>Yes</option>
</select>
</div>
<div>
<label>Scholarship Applied?</label>
<select name="scholarship_applied">
<option>No</option>
<option>Yes</option>
</select>
</div>
</div>

<label>Permanent Address</label>
<textarea name="permanent_address"></textarea>

<label>Local Address</label>
<textarea name="local_address"></textarea>

<!-- ACADEMIC DETAILS -->
<div class="section-title">Previous Academic Details</div>

<label>Applying For</label>
<select id="yearSelect" onchange="setRows()">
<option value="2">Second Year</option>
<option value="4">Third Year</option>
</select>

<table id="academicTable">
<tr>
<th>Year</th>
<th>Exam Seat No</th>
<th>Status</th>
<th>Month & Year</th>
<th>Total Marks</th>
</tr>
</table>

<div class="center">
    <button type="submit" class="btn">Next</button>
</div>

</form>

</div>

<script>
let currentYear = new Date().getFullYear();
document.getElementById("admissionYear").innerText =
"Admission Year : " + currentYear + " - " + (currentYear+1);

function setRows(){
    let table = document.getElementById("academicTable");
    table.innerHTML = `
    <tr>
        <th>Year</th>
        <th>Exam Seat No</th>
        <th>Status</th>
        <th>Month & Year</th>
        <th>Total Marks</th>
    </tr>`;
    let count = document.getElementById("yearSelect").value;
    for(let i=0;i<count;i++){
        addRow(i+1);
    }
}

function addRow(year){
    let table = document.getElementById("academicTable");
    let row = table.insertRow();
    row.innerHTML = `
    <td>Year ${year}</td>
    <td><input name="exam_seat_no[]"></td>
    <td>
        <select name="status[]">
            <option value="Passed">Passed</option>
            <option value="ATKT">ATKT</option>
            <option value="Failed">Failed</option>
        </select>
    </td>
    <td><input name="month_year[]"></td>
    <td><input name="total_marks[]"></td>
    `;
}

setRows();
</script>

</body>
</html>
