<?php
include("DB.php");
include("student_auth.php");

$sql = "
SELECT s.*, d.department_name, sem.semester_name
FROM students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
LEFT JOIN semester sem ON s.semester_id = sem.semester_id
WHERE s.student_id = $studentId
";

$res = mysqli_query($conn, $sql);

if(!$res || mysqli_num_rows($res)==0){
    die("Student not found");
}

$student = mysqli_fetch_assoc($res);

$currentSemester = $student['semester_name'] ?? 'Not Assigned';

$username       = $student['student_name'] ?? '';
$dob            = $student['dob'] ?? '';
$gender         = $student['gender'] ?? '';
$email          = $student['email'] ?? '';
$blood_group    = $student['blood_group'] ?? '';
$mobile         = $student['mobile_no'] ?? '';
$category       = $student['caste'] ?? '';
$admission_year = $student['admission_year'] ?? '';
$course         = $student['department_name'] ?? '';
$semester       = $student['semester_name'] ?? '';
$academic_status= $student['status'] ?? '';


$addRes = mysqli_query($conn,
    "SELECT * FROM student_additional_details WHERE student_id=$studentId"
);
$add = mysqli_fetch_assoc($addRes);
$address = $add['permanent_address'] ?? "Not Available";


$allDocs = [
    "Birth Certificate",
    "Leaving Certificate",
    "10th Marksheet",
    "12th Marksheet",
    "Caste Certificate",
    "Income Certificate",
    "Aadhar Card",
    "Passport Size Photo"
];


$uploadedDocs = [];
$docRes = mysqli_query($conn,
    "SELECT document_type FROM documents WHERE student_id=$studentId"
);

if($docRes){
    while($row = mysqli_fetch_assoc($docRes)){
        $uploadedDocs[] = $row['document_type'];
    }
}


if(isset($_POST['upload_doc'])){

    $docName = $_POST['doc_name'];

    if($_FILES['doc_file']['error']==0){

        $dir="uploads/";
        if(!is_dir($dir)) mkdir($dir,0777,true);

        $file=time()."_".basename($_FILES['doc_file']['name']);
        move_uploaded_file($_FILES['doc_file']['tmp_name'],$dir.$file);

        mysqli_query($conn,"
            INSERT INTO documents(student_id,document_type,file_path)
            VALUES($student_id,'$docName','$dir$file')
        ");

        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>

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
    font-family: "Segoe UI", Arial, sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}


.header{
    height:70px;
    background:linear-gradient(135deg,#5f84a9,#4f6d8a);
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.header-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.profile-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    background:white;
    color:#5f84a9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:bold;
}

.header-title{
    font-size:22px;
    font-weight:600;
    letter-spacing:0.5px;
}

.header-right{
    display:flex;
    align-items:center;
    gap:20px;
}
.container{
    display:flex;
    height:calc(100vh - 70px);
}


.sidebar{
    width:260px;
    background:#eef3f7;
    border-right:1px solid var(--border);
}

.sidebar a{
    display:block;
    padding:18px 22px;
    border-bottom:1px solid #dbe6ed;
    text-decoration:none;
    color:var(--text);
    font-size:14px;
    font-weight:600;
    transition:all 0.25s ease;
}

.sidebar a:hover{
    background:#dde8f0;
    padding-left:28px;
}

.sidebar a.active{
    background:#dde8f0;
    border-left:4px solid var(--primary);
}
.content{flex:1;padding:20px;}
.cards{display:flex;gap:20px;}
.card{
    background:#e6f3f6;padding:20px;
    width:50%;border-radius:10px;
}
.documents{
    margin-top:20px;background:#e6f3f6;
    padding:20px;border-radius:10px;
}
.doc-grid{
    display:grid;grid-template-columns:1fr 1fr;
    gap:10px;
}
.doc{
    background:#fff;padding:10px;
    border-radius:6px;
    display:flex;justify-content:space-between;
    align-items:center;
}
.uploaded{color:green;font-weight:bold;}
.dropdown{
    position:relative;
}

.dropdown-btn{
    background:#274b73;
    color:#fff;
    border:none;
    padding:6px 14px;
    border-radius:14px;
    cursor:pointer;
    font-size:13px;
}

.dropdown-content{
    display:none;
    position:absolute;
    right:0;
    top:35px;
    background:#fff;
    min-width:180px;
    border-radius:6px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
    z-index:10;
}

.dropdown-content div{
    padding:10px;
    cursor:pointer;
    font-size:13px;
    color:#000;
}

.dropdown-content div:hover{
    background:#eaf5f8;
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
</style>
</head>

<body>

<div class="header">

    <div class="header-left">
        <div class="user-circle">👤</div>
        <strong><?php echo $username; ?></strong>
    </div>

    <div class="header-right">

       <div class="dropdown">
    <button class="dropdown-btn" onclick="toggleDropdown()">
        <span id="selectedOption">
            Semester <?php echo $currentSemester; ?>
        </span> ▼
    </button>

    
</div>

        <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>

    </div>
</div>

<div class="container">

<div class="sidebar">
    <a href="Student_Dash_Profile.php" class="active">PROFILE</a>
    <a href="attendance_student.php">ATTENDANCE</a>
    <a href="Student_Dash_Marks.php">MARKS</a>
    <a href="application.php">APPLICATION</a>
    <a href="student_notification.php">NOTIFICATIONS</a>
</div>

<div class="content">

<div class="cards">

<div class="card">
<h3>PERSONAL DETAILS</h3>
<p><b>Name:</b> <?php echo $username; ?></p>
<p><b>DOB:</b> <?php echo $dob; ?></p>
<p><b>Gender:</b> <?php echo $gender; ?></p>
<p><b>Email:</b> <?php echo $email; ?></p>
<p><b>Mobile:</b> <?php echo $mobile; ?></p>
<p><b>Blood Group:</b> <?php echo $blood_group; ?></p>
<p><b>Category:</b> <?php echo $category; ?></p>
<p><b>Address:</b> <?php echo $address; ?></p>
</div>

<div class="card">
<h3>ACADEMIC DETAILS</h3>
<p><b>Course:</b> <?php echo $course; ?></p>
<p><b>Semester:</b> <?php echo $semester; ?></p>
<p><b>Admission Year:</b> <?php echo $admission_year; ?></p>
<p><b>Status:</b> <?php echo $academic_status; ?></p>
</div>

</div>

<div class="documents">
<h3>DOCUMENTS</h3>
<div class="doc-grid">

<?php foreach($allDocs as $doc): ?>
<div class="doc">
<span><?php echo $doc; ?></span>

<?php if(in_array($doc,$uploadedDocs)): ?>
    <span class="uploaded">✔ Uploaded</span>
<?php else: ?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="doc_name" value="<?php echo $doc; ?>">
    <input type="file" name="doc_file" required>
    <button name="upload_doc">Upload</button>
</form>
<?php endif; ?>

</div>
<?php endforeach; ?>

</div>
</div>

</div>
</div>

</body>
</html>