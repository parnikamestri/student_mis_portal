<?php

include "DB.php";
include "admin_auth.php";

$error = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title     = trim($_POST['title']);
    $category  = $_POST['category'];
    $message   = trim($_POST['message']);
    $audience  = $_POST['audience'];
    $class_id  = NULL;

    if($audience == "Specific"){
        $class_id = $_POST['class'] ?? NULL;
    }


    $file_path = NULL;

    if(isset($_FILES['file']) && $_FILES['file']['name'] != ''){
        $uploadDir = "uploads/";

        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time().'_'.basename($_FILES['file']['name']);
        $targetFile = $uploadDir.$fileName;

        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
            $file_path = $targetFile;
        }
    }

 
    $stmt = $conn->prepare("INSERT INTO announcement_faculty 
        (faculty_id, title, category, message, file_path, audience_type, class_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssssi",
        $faculty_id,
        $title,
        $category,
        $message,
        $file_path,
        $audience,
        $class_id
    );

    if($stmt->execute()){
        header("Location: admin_announcement.php?success=1");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Announcement</title>
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

    .logout a{
        color:white;
        text-decoration:none;
        font-size:16px;
    }


    .main {
        display: flex;
        height: calc(100vh - 70px);
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
        transition:0.25s;
    }
    .sidebar a:hover{
        background:#dde8f0;
        padding-left:28px;
    }
    .sidebar a.active{
        background:#dde8f0;
        border-left:4px solid var(--primary);
    }
        
    .content{
        flex:1;
        padding:30px;
        background:#fff;
    }

    h2{
        margin-top:0;
        color:#3f6fa1;
    }

    .form-group{
        margin-bottom:18px;
    }

    label{
        display:block;
        margin-bottom:6px;
        font-weight:600;
    }

    input[type=text],
    select,
    textarea{
        width:60%;
        padding:8px 10px;
        border:1px solid #ccc;
        border-radius:4px;
        outline:none;
    }

    input[type=text]:focus,
    select:focus,
    textarea:focus{
        border-color:#3f6fa1;
    }

    textarea{
        height:100px;
    }

    .btn{
        background:#3f6fa1;
        color:#fff;
        padding:10px 22px;
        border:none;
        border-radius:20px;
        cursor:pointer;
        font-weight:600;
        transition:0.3s;
    }

    .btn:hover{
        background:#345f8c;
    }

    .cancel{
        background:#777;
    }

    .cancel:hover{
        background:#555;
    }

    .error{
        color:red;
        margin-bottom:12px;
        font-weight:500;
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
    } 
</style>
</head>
<body>


<div class="header">
    <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $username; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>

<div class="main">

<div class="sidebar">
    <a href="Admin_Dash_StudentList.php">STUDENT</a>
    <a href="faculty.php">FACULTY</a>
    <a href="admin_notification.php">NOTIFICATIONS</a>
    <a href="admin_announcement.php" class="active">ANNOUNCEMENTS</a>
    <a href="create_profile.php">FACULTY REGISTRATION</a>
    <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
    <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
    <a href="program_registration.php">PROGRAM REGISTRATION</a>
</div>

<div class="content">

<h2>Create Announcement</h2>

<?php if($error != ""){ echo "<div class='error'>$error</div>"; } ?>

<form method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" required>
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category" required>
            <option value="Academic">Academic</option>
            <option value="Class">Class</option>
            <option value="General">General</option>
        </select>
    </div>

    <div class="form-group">
        <label>Message</label>
        <textarea name="message" required></textarea>
    </div>

    <div class="form-group">
        <label>Attach File (Optional)</label>
        <input type="file" name="file">
    </div>

    <div class="form-group">
        <label>Audience</label><br>
        <input type="radio" name="audience" value="All" checked onclick="toggleClass()"> All Students
        <input type="radio" name="audience" value="Specific" onclick="toggleClass()"> Specific Class
    </div>

    <div class="form-group" id="classDiv" style="display:none;">
        <label>Select Class</label>
        <select name="class">
            <?php
            $result = $conn->query("SELECT class_id, class_name FROM class");
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['class_id']."'>".$row['class_name']."</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn">Post Announcement</button>
    <button type="button" class="btn cancel" onclick="window.location.href='announcement.php'">Cancel</button>

</form>

</div>
</div>

<script>
function toggleClass(){
    var audience = document.querySelector('input[name="audience"]:checked').value;
    document.getElementById("classDiv").style.display =
        (audience === "Specific") ? "block" : "none";
}
</script>

</body>
</html>