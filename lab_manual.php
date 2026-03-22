<?php
session_start();

// SUBJECT LIST 
$subjects = ["STE","OSY","CLC"];

// STUDENT LIST
$students = [
    ["23140210201","Manali Suresh Juvale"],
    ["23140210202","Parnika Vishwanath Mestri"],
    ["23140210203","Vaidehi Dattaram Medhekar"],
    ["23140210204","Teena Ashok Salunke"],
    ["23140210205","Saniya Ganesh Patil"],
    ["23140210206","Aarohi Shankar Patil"],
];

$showTable = false;

// LOAD TABLE
if(isset($_POST['go']) && $_POST['subject'] !== ""){
    $showTable = true;
}

// SAVE PRINT
if(isset($_POST['save'])){
    echo "<script>window.print();</script>";
}

// EXPORT EXCEL
if(isset($_POST['excel'])){
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=lab_manual_report.xls");

    echo "Enrollment No\tStudent Name\t1\t2\t3\t4\t5\tTotal\n";
    
    foreach($students as $s){
        echo $s[0]."\t".$s[1]."\t\t\t\t\t\t\n";
    }

    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>PRACTICAL LAB ENTRY</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
/* TOP BAR */
.topbar{
    background-color:#5F82A6;
    color:white;
    padding:16px 28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:24px;
    font-weight:bold;
}

/* CENTER BOX */
.main-box{
    width:100%;
    display:flex;
    justify-content:center;
    text-align:center;
    margin-top:40px;
}

/* CONTENT */
.content-box{
    width:900px;
    padding:20px;
}

label{
    font-size:22px;
    font-weight:bold;
    margin-right:15px;
}

/* SELECT BOX */
select{
    padding:8px 25px;
    font-size:16px;
    border-radius:20px;
    width:210px;
    border:1px solid #888;
    margin-bottom:25px;
}

/* TABLE */
.table-box{
    width:850px;
    margin:auto;
    margin-top:20px;
}

.table th{
    background:#e9eef3;
    font-size:16px;
}

.table td{
    height:45px;
}

/* INPUT BOXES */
.input-box{
    width:55px;
    text-align:center;
    border:1px solid #aaa;
    border-radius:5px;
    padding:3px;
}

/* BUTTONS */
.btn-custom{
    background:#d8e9ef;
    border-radius:20px;
    padding:12px 35px;
    color:black;
    font-weight:bold;
    border:none;
    font-size:18px;
    margin:10px;
}

.btn-custom:hover{
    background:#bcd5e0;
}

</style>

<script>
// AUTO TOTAL
function calcTotal(id){
    let t1 = parseInt(document.getElementById("p1"+id).value) || 0;
    let t2 = parseInt(document.getElementById("p2"+id).value) || 0;
    let t3 = parseInt(document.getElementById("p3"+id).value) || 0;
    let t4 = parseInt(document.getElementById("p4"+id).value) || 0;
    let t5 = parseInt(document.getElementById("p5"+id).value) || 0;

    document.getElementById("total"+id).value = t1+t2+t3+t4+t5;
}
</script>

</head>
<body>

<div class="topbar">
    Faculty Profile
    <a href="logout.php" style="color:white; font-size:16px; text-decoration:none;">Sign Out</a>
</div>

<div class="main-box">
<div class="content-box">

<form method="post">

<label>Subject</label>
<select name="subject" required>
    <option value="">select subject</option>
    <?php foreach($subjects as $s){ ?>
        <option value="<?= $s ?>"><?= $s ?></option>
    <?php } ?>
</select>

<br>

<button class="btn-custom" type="submit" name="go">Load</button>

<?php if($showTable){ ?>

<div class="table-box">
<table class="table table-bordered text-center">

<tr>
<th>Enrollment No</th>
<th>Student Name</th>
<th colspan="5">Practicals</th>
<th>Total</th>
</tr>

<tr>
<th></th>
<th></th>
<th>1</th>
<th>2</th>
<th>3</th>
<th>4</th>
<th>5</th>
<th></th>
</tr>

<?php $i=1; foreach($students as $s){ ?>
<tr>
<td><?= $s[0] ?></td>
<td><?= $s[1] ?></td>

<td><input class="input-box" id="p1<?= $i ?>" oninput="calcTotal(<?= $i ?>)"></td>
<td><input class="input-box" id="p2<?= $i ?>" oninput="calcTotal(<?= $i ?>)"></td>
<td><input class="input-box" id="p3<?= $i ?>" oninput="calcTotal(<?= $i ?>)"></td>
<td><input class="input-box" id="p4<?= $i ?>" oninput="calcTotal(<?= $i ?>)"></td>
<td><input class="input-box" id="p5<?= $i ?>" oninput="calcTotal(<?= $i ?>)"></td>

<td><input class="input-box" id="total<?= $i ?>" readonly></td>
</tr>
<?php $i++; } ?>

</table>
</div>

<br>

<button class="btn-custom" type="submit" name="save">Export PDF</button>
<button class="btn-custom" type="submit" name="excel">Export Excel</button>

<?php } ?>

</form>

</div>
</div>

</body>
</html>
