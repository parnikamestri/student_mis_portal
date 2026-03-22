<?php
include "DB.php";
include "office_auth.php";
$department_id = $_POST['department_id'] ?? '';
$semester = $_POST['semester'] ?? '';
$department_name = "Department";


if($department_id){
    $dept_query = mysqli_query($conn,
        "SELECT department_name FROM departments WHERE dept_id='$department_id'"
    );
    if(mysqli_num_rows($dept_query)>0){
        $dept = mysqli_fetch_assoc($dept_query);
        $department_name = $dept['department_name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Office | View Student Applications</title>

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
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI, Arial, sans-serif;}
body{background:var(--bg);color:var(--text);}


.header {
    height: 70px;
    background-color: #5b7fa6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    color: #5b7fa6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.header-title {
    font-size: 22px;
    font-weight: bold;
}

.logout{
    color:white;
    text-decoration:none;
    font-size:15px;
}

.logout:hover{
    opacity:0.8;
}
.logout-btn{
    display:inline-block;
    background: linear-gradient(135deg,#e53935,#c62828);
    color:white;
    padding:8px 18px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition:all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg,#c62828,#b71c1c);
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.25);
}
.container{padding:35px;}
.card{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 10px 22px rgba(0,0,0,0.08);
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}
.top-bar h2{
    font-size:22px;
    font-weight:600;
}

.semester-select{
    padding:8px 18px;
    border-radius:22px;
    border:1px solid #ccc;
    outline:none;
}

table{
    width:100%;
    border-collapse:collapse;
}
th{
    background:#f6f8fa;
    padding:14px;
    font-weight:600;
}
td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:center;
}
tr:hover{
    background:#f9fbfc;
}

.status{
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}
.pending{background:#f1f3f5;color:#555;}
.accepted{background:#e6f4ea;color:#1e7e34;}
.rejected{background:#fdecea;color:#c82333;}

.view-btn{
    padding:7px 18px;
    background:#5f83a9;
    color:#fff;
    border-radius:20px;
    text-decoration:none;
    font-size:13px;
}
.view-btn:hover{
    background:#4b6f94;
}
.logout{
    color:white;
    text-decoration:none;
    font-size:15px;
}

.logout:hover{
    opacity:0.8;
}
.logout-btn{
    display:inline-block;
    background: linear-gradient(135deg, #e53935, #c62828);
    color:white;
    padding:8px 16px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition: all 0.3s ease;
}

.logout-btn:hover{
    background: linear-gradient(135deg, #c62828, #b71c1c);
    transform: translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
</style>
</head>
<body>

<div class="header">

    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title">
            <?php echo $username; ?>
        </div>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>

</div>


<div class="container">
<div class="card">

<div class="top-bar">
<h2><?= strtoupper($department_name) ?> Department</h2>

<form method="post">
<input type="hidden" name="department_id" value="<?= $department_id ?>">

<select name="semester" class="semester-select" onchange="this.form.submit()" required>
<option value="">Select Semester</option>
<option value="1" <?= ($semester==1)?"selected":"" ?>>Semester 1</option>
<option value="2" <?= ($semester==2)?"selected":"" ?>>Semester 2</option>
<option value="3" <?= ($semester==3)?"selected":"" ?>>Semester 3</option>
<option value="4" <?= ($semester==4)?"selected":"" ?>>Semester 4</option>
<option value="5" <?= ($semester==5)?"selected":"" ?>>Semester 5</option>
<option value="6" <?= ($semester==6)?"selected":"" ?>>Semester 6</option>
</select>
</form>

</div>

<table>
<thead>
<tr>
<th>SR NO</th>
<th>ENROLLMENT NO</th>
<th>STUDENT NAME</th>
<th>SEMESTER</th>
<th>STATUS</th>
<th>ACTION</th>
</tr>
</thead>
<tbody>

<?php
if($department_id && $semester){

$query = "
SELECT s.*, sem.semester_number
FROM students s
JOIN semester sem ON s.semester_id = sem.semester_id
WHERE s.dept_id='$department_id'
AND sem.semester_number='$semester'
";

$result = mysqli_query($conn,$query);
$i=1;

if(mysqli_num_rows($result)>0){
while($row=mysqli_fetch_assoc($result)){

$statusClass = strtolower($row['status']);

echo "<tr>
<td>".$i++."</td>
<td>".$row['enrollment_id']."</td>
<td>".$row['student_name']."</td>
<td>".$row['semester_number']."</td>
<td><span class='status $statusClass'>".$row['status']."</span></td>
<td>
<a class='view-btn' href='view_student_form.php?id=".$row['student_id']."'>
View
</a>
</td>
</tr>";
}
}else{
echo "<tr><td colspan='6'>No data available</td></tr>";
}

}else{
echo "<tr><td colspan='6'>Please select semester</td></tr>";
}
?>

</tbody>
</table>

</div>
</div>

</body>
</html>