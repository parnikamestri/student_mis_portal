<?php
include "office_auth.php";
include("DB.php");

if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Invalid Access");
}

$student_id = intval($_GET['id']);


$stmt = $conn->prepare("
SELECT s.*, sem.semester_number, d.department_name
FROM students s
LEFT JOIN semester sem ON s.semester_id = sem.semester_id
LEFT JOIN departments d ON s.dept_id = d.dept_id
WHERE s.student_id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if(!$student){
    die("Student Not Found");
}


$acad_query = mysqli_query($conn,"
SELECT * FROM academic_details
WHERE student_id='$student_id'
");

$doc_query = mysqli_query($conn,"
SELECT * FROM documents
WHERE student_id='$student_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Admission Form</title>

<style>
:root{
    --primary:#4f6d8a;
    --bg:#f4f7f9;
    --text:#2c3e50;
}

/* Reset */

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

/* CONTAINER */

.container{
    display:flex;
    justify-content:center;
    margin:40px 0;
}

.card{
    background:#fff;
    width:900px;
    border-radius:14px;
    padding:30px 40px;
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}

.title{
    font-size:22px;
    font-weight:700;
    margin-bottom:25px;
}


/* SECTION */

.section{
    margin-bottom:30px;
}

.section-title{
    font-weight:600;
    margin-bottom:12px;
}


/* GRID LAYOUT */

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:22px 40px;
}

.field label{
    font-size:13px;
    color:#666;
}

.field div{
    margin-top:4px;
    font-weight:600;
    border-bottom:1px dashed #ccc;
    padding-bottom:4px;
}


/* STATUS */

.status{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    background:#eaeaea;
    font-weight:600;
}


/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
}

th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

th{
    background:#f7f7f7;
}


/* ACTION BUTTONS */

.actions{
    display:flex;
    justify-content:flex-end;
    margin-top:25px;
}

button{
    border:none;
    padding:9px 18px;
    border-radius:20px;
    font-weight:600;
    cursor:pointer;
}

.print{
    background:#e9ecef;
    color:#333;
    border:1px solid #ccc;
}

.print:hover{
    background:#dee2e6;
}


/* VIEW BUTTON */

.view-btn{
    display:inline-block;
    padding:6px 14px;
    background:linear-gradient(135deg,#4e73df,#224abe);
    color:#fff;
    text-decoration:none;
    font-size:13px;
    font-weight:500;
    border-radius:6px;
    transition:all .3s ease;
    box-shadow:0 2px 6px rgba(0,0,0,.15);
}

.view-btn:hover{
    background:linear-gradient(135deg,#2e59d9,#1c3faa);
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,.25);
}

.view-btn i{
    margin-right:5px;
}


/* ACTION SECTION */

.action-section{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
    margin-top:20px;
}

.print-btn{
    background:#6c757d;
    color:#fff;
    padding:7px 14px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.approve-btn{
    background:#28a745;
    color:#fff;
    padding:7px 14px;
    border-radius:5px;
    text-decoration:none;
}

.reject-btn{
    background:#dc3545;
    color:#fff;
    padding:7px 14px;
    border-radius:5px;
    text-decoration:none;
}

.correction-btn{
    background:#ffc107;
    color:#000;
    padding:7px 14px;
    border-radius:5px;
    border:none;
    cursor:pointer;
}


/* MODAL */

.modal{
    display:none;
    position:fixed;
    z-index:1000;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}

.modal-content{
    background:#fff;
    margin:10% auto;
    padding:20px;
    width:400px;
    border-radius:8px;
}

.close{
    float:right;
    font-size:22px;
    cursor:pointer;
}


/* FORM */

textarea{
    width:100%;
    height:100px;
    padding:8px;
    border-radius:5px;
    border:1px solid #ccc;
}

.send-btn{
    background:#ffc107;
    border:none;
    padding:8px 15px;
    border-radius:5px;
    cursor:pointer;
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

<div class="title">Student Admission Form</div>


<div class="section">
<div class="section-title">Basic Details</div>
<div class="grid">
    <div class="field"><label>Name</label><div><?= htmlspecialchars($student['student_name']) ?></div></div>
    <div class="field"><label>Email</label><div><?= htmlspecialchars($student['email']) ?></div></div>
    <div class="field"><label>Mobile</label><div><?= htmlspecialchars($student['mobile_no']) ?></div></div>
    <div class="field"><label>Department</label><div><?= htmlspecialchars($student['department_name']) ?></div></div>
    <div class="field"><label>Semester</label><div><?= htmlspecialchars($student['semester_number']) ?></div></div>
    <div class="field"><label>Status</label><div><span class="status"><?= htmlspecialchars($student['status']) ?></span></div></div>
</div>
</div>


<div class="section">
<div class="section-title">Academic Details</div>
<table>
<tr>
<th>Year</th>
<th>Seat No</th>
<th>Status</th>
<th>Month-Year</th>
<th>Total Marks</th>
</tr>

<?php
if($acad_query && mysqli_num_rows($acad_query) > 0){
    while($acad = mysqli_fetch_assoc($acad_query)){
        echo "<tr>
        <td>{$acad['year_label']}</td>
        <td>{$acad['exam_seat_no']}</td>
        <td>{$acad['status']}</td>
        <td>{$acad['month_year']}</td>
        <td>{$acad['total_marks']}</td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='5'>No Academic Records</td></tr>";
}
?>
</table>
</div>

<div class="section">
<div class="section-title">Uploaded Documents</div>

<table>
<tr>
<th>Document Type</th>
<th>Status</th>
<th>View</th>
</tr>

<?php
if($doc_query && mysqli_num_rows($doc_query) > 0){
    while($doc = mysqli_fetch_assoc($doc_query)){

        $file = $doc['file_path'];

        echo "<tr>
        <td>".htmlspecialchars($doc['document_type'])."</td>
        <td>";

        if(!empty($file)){
            echo "<span class='status'>Uploaded</span>";
        }else{
            echo "<span class='status'>Pending</span>";
        }

        echo "</td>
        <td>";

        if(!empty($file)){
    echo "<a href='".$file."' target='_blank' class='view-btn'>
            👁 View
          </a>";
}else{
    echo "<span style='color:red;'>Pending</span>";
}

        echo "</td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='3'>No Documents Uploaded</td></tr>";
}
?>
</table>
</div>

<div class="action-section">

    <button onclick="window.print()" class="print-btn">🖨 Print</button>

    <a href="update_status.php?id=<?php echo $student['student_id']; ?>&action=approve"
       class="approve-btn">Approve</a>

    <a href="update_status.php?id=<?php echo $student['student_id']; ?>&action=reject"
       class="reject-btn">Reject</a>

    <button class="correction-btn"
    onclick="openCorrectionModal(<?php echo $student['student_id']; ?>)">
    Required Correction
</button>

</div>

<div id="correctionModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <h3>Required Correction</h3>

        <form method="POST" action="update_status.php">
            <input type="hidden" name="student_id" id="modal_student_id">

            <textarea name="correction_message"
                placeholder="Enter correction details..."
                required></textarea>

            <br>

            <button type="submit"
                name="send_correction"
                class="send-btn">
                Send
            </button>
        </form>
    </div>
</div>
</div>
</div>
<script>
function openCorrectionModal(id){
    document.getElementById("correctionModal").style.display="block";
    document.getElementById("modal_student_id").value=id;
}

function closeModal(){
    document.getElementById("correctionModal").style.display="none";
}

window.onclick = function(event){
    var modal = document.getElementById("correctionModal");
    if(event.target == modal){
        modal.style.display = "none";
    }
}
</script>
</body>
</html>