<?php
session_start();


if(!isset($_SESSION['student_id'])){
    die("Session expired. Please fill application form again.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Documents</title>

<style>
body{
    font-family:"Segoe UI",Arial,sans-serif;
    background:#edf1f5;
    padding:30px;
}
.container{
    max-width:850px;
    margin:auto;
    background:#fff;
    border:1px solid #cfd6dd;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
h2{
    text-align:center;
    padding:20px;
    color:#2c4e6e;
    border-bottom:2px solid #5f84a9;
    margin:0;
}
.section{
    padding:10px 0;
}
.doc-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 25px;
    border-bottom:1px solid #e3e8ee;
}
.doc-row:last-child{
    border-bottom:none;
}
.doc-name{
    font-weight:600;
    color:#333;
    font-size:14px;
}
input[type="file"]{
    font-size:13px;
}
.photo-row{
    background:#f4f7fb;
    border-left:4px solid #5f84a9;
}
.center{
    text-align:center;
    padding:25px;
}
.btn{
    background:#5f84a9;
    color:white;
    border:none;
    padding:11px 35px;
    border-radius:25px;
    cursor:pointer;
    font-size:15px;
}
.btn:hover{
    background:#4a6f91;
}
.note{
    font-size:12px;
    color:#666;
    margin-left:25px;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="container">

<h2>Upload Documents</h2>

<form id="docForm" action="save_documents.php" method="post" enctype="multipart/form-data">

<div class="section">

<div class="doc-row">
    <div class="doc-name">Admission Form (Original)</div>
    <input type="file" name="admissionForm" id="admissionForm">
</div>

<div class="doc-row">
    <div class="doc-name">First Year Marksheet Receipt</div>
    <input type="file" name="fyReceipt" id="fyReceipt">
</div>

<div class="doc-row">
    <div class="doc-name">First Semester Marksheet</div>
    <input type="file" name="sem1" id="sem1">
</div>

<div class="doc-row">
    <div class="doc-name">Second Semester Marksheet</div>
    <input type="file" name="sem2" id="sem2">
</div>

<div class="doc-row">
    <div class="doc-name">Third Semester Marksheet</div>
    <input type="file" name="sem3" id="sem3">
</div>

<div class="doc-row">
    <div class="doc-name">Fourth Semester Marksheet</div>
    <input type="file" name="sem4" id="sem4">
</div>

<div class="doc-row">
    <div class="doc-name">Caste Certificate</div>
    <input type="file" name="caste" id="caste">
</div>

<div class="doc-row">
    <div class="doc-name">Caste Validity Certificate</div>
    <input type="file" name="casteValidity" id="casteValidity">
</div>

<div class="doc-row">
    <div class="doc-name">Non-Creamy Layer Certificate</div>
    <input type="file" name="nonCreamy" id="nonCreamy">
</div>

<div class="doc-row">
    <div class="doc-name">Income Certificate</div>
    <input type="file" name="income" id="income">
</div>

<div class="doc-row">
    <div class="doc-name">Aadhar Card</div>
    <input type="file" name="aadhaar" id="aadhaar">
</div>

<div class="doc-row">
    <div class="doc-name">Ration Card</div>
    <input type="file" name="ration" id="ration">
</div>

<div class="doc-row photo-row">
    <div class="doc-name">Student Photo</div>
    <input type="file" name="photo" id="photo" accept="image/*">
</div>

<p class="note">
📌 Note: If any caste related document is missing, undertaking will be required.
</p>

</div>

<div class="center">
    <button type="button" class="btn" onclick="validateDocuments()">
        Submit Documents
    </button>
</div>

</form>

</div>

<script>
function validateDocuments(){

    let compulsory = [
        'admissionForm','fyReceipt','sem1','sem2','sem3','sem4',
        'aadhaar','ration','photo'
    ];

    for(let id of compulsory){
        if(document.getElementById(id).files.length === 0){
            alert(" All compulsory documents must be uploaded!");
            return;
        }
    }

    document.getElementById("docForm").submit();
}
</script>

</body>
</html>
