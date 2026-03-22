<?php
include "DB.php"; 
include "faculty_auth.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $message = $_POST['message'] ?? '';
    $audience = $_POST['audience'] ?? 'All';
    $class_id = $_POST['class'] ?? NULL;

    
    $file_path = NULL;
    if(isset($_FILES['file']) && $_FILES['file']['name'] != ''){
        $uploadDir = "uploads/";
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = time().'_'.basename($_FILES['file']['name']);
        $targetFile = $uploadDir.$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
            $file_path = $targetFile;
        }
    }

   
    $stmt = $conn->prepare("INSERT INTO announcement_faculty (faculty_id, title, category, message, file_path, audience_type, class_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $faculty_id, $title, $category, $message, $file_path, $audience, $class_id);

    if($stmt->execute()){
        header("Location: announcement.php?success=1");
        exit;
    } else {
        $error = "Error: ".$stmt->error;
    }
}
$semesterQuery = mysqli_query($conn,
    "SELECT 
    s.semester_id,
    p.program_code,
    s.semester_number
FROM semester s
JOIN program p ON s.program_id = p.program_id
WHERE s.status='Active'
ORDER BY p.program_code, s.semester_number"
);
$classes = [];
while($row = mysqli_fetch_assoc($semesterQuery)){
    $classes[] = $row;
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

    .back-btn{
        position:absolute;
        left:15px;
        top:50%;
        transform:translateY(-50%);
        width:38px;
        height:38px;
        background:rgba(255,255,255,0.18);
        border-radius:10px;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        transition:background 0.2s;
    }

    .back-btn svg{
        width:18px;
        height:18px;
        stroke:#fff;
    }

    .back-btn:hover{
        background:rgba(255,255,255,0.3);
    }




    .content{
        flex:1;
        background:#fff;
        margin:25px;
        padding:35px;
        border-radius:10px;
        border:1px solid #dfe6ec;
        box-shadow:0 4px 12px rgba(0,0,0,0.05);
    }

    .content h2{
        margin-top:0;
        font-size:22px;
        border-bottom:2px solid #e6eef4;
        padding-bottom:10px;
    }



    .form-group{
        margin-bottom:18px;
    }

    label{
        display:block;
        font-weight:600;
        margin-bottom:6px;
        font-size:14px;
    }

    input[type=text],
    textarea,
    select{
        width:60%;
        padding:9px 10px;
        border:1px solid #cfd8df;
        border-radius:5px;
        font-size:14px;
    }

    textarea{
        height:100px;
        resize:none;
    }

    input:focus,
    textarea:focus,
    select:focus{
        outline:none;
        border-color:#3f6fa1;
    }



    .radio-group{
        margin-top:8px;
        font-size:14px;
    }

    .radio-group input{
        margin-right:6px;
    }



    .buttons{
        margin-top:30px;
        display:flex;
        justify-content:space-between;
    }

    .btn{
        background:#3f6fa1;
        color:white;
        padding:10px 26px;
        border-radius:25px;
        border:none;
        cursor:pointer;
        font-size:13px;
        transition:background 0.2s, transform 0.1s;
    }

    .btn:hover{
        background:#345f8c;
        transform:translateY(-1px);
    }

    .cancel{
        background:#7f8c8d;
    }

    .cancel:hover{
        background:#6c7a7b;
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
        background:linear-gradient(135deg, #e53935, #c62828);
        color:white;
        padding:8px 16px;
        border-radius:6px;
        text-decoration:none;
        font-size:14px;
        font-weight:500;
        transition:all 0.3s ease;
    }

    .logout-btn:hover{
        background:linear-gradient(135deg, #c62828, #b71c1c);
        transform:translateY(-2px);
        box-shadow:0 4px 10px rgba(0,0,0,0.2);
    }
</style>
</head>
<body>

<div class="header">
   <div class="header-left">
        <div class="profile-icon">👤</div>
        <div class="header-title"><?php echo $name; ?></div>
    </div>
    <a href="logout.php" class="logout-btn">
    <span>Logout</span>
</a>
</div>

<div class="container">
    <div class="sidebar">
        <a href="faculty_attendance_select.php">ATTENDANCE</a>
        <a href="marks_entry.php">MARKS ENTRY</a>
        <a href="reports.php">REPORTS</a>
        <a href="notifications.php">NOTIFICATIONS</a>
        <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
        <a href="announcement.php" class="active">ANNOUNCEMENT</a>
    </div>

    <div class="content">
        <h2>Create Announcement</h2>
        <?php if(isset($error)){ echo "<p style='color:red;'>$error</p>"; } ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title :</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label>Category :</label>
                <select name="category" id="category" required>
                    <option value="Academic">Academic</option>
                    <option value="Class">Class</option>
                    <option value="General">General</option>
                </select>
            </div>

            <div class="form-group">
                <label>Message :</label>
                <textarea name="message" id="message" required></textarea>
            </div>

            <div class="form-group">
                <label>Attach File (Optional) :</label>
                <input type="file" name="file">
            </div>

            <div class="form-group">
                <label>Audience :</label>
                <div class="radio-group">
                    <input type="radio" name="audience" value="All" checked onclick="toggleClass()"> All Students
                    <input type="radio" name="audience" value="Specific" onclick="toggleClass()"> Specific Class
                </div>
            </div>

            <div class="form-group" id="classDiv" style="display:none;">
                <label>Class :</label>
                <select name="semester_id" required>
                        <option value="">-- Select --</option>

                        <?php foreach($classes as $row){ ?>
                            <option value="<?= $row['semester_id']; ?>">
                                <?= $row['program_code']; ?> - SEM <?= $row['semester_number']; ?>
                            </option>
                        <?php } ?>

                    </select>
            </div>

            <div class="buttons">
                <button type="submit" class="btn">Post Announcement</button>
                <button type="button" class="btn cancel" onclick="cancel()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleClass(){
    let selected = document.querySelector('input[name="audience"]:checked').value;
    document.getElementById("classDiv").style.display = (selected==="Specific") ? "block" : "none";
}
function cancel(){ window.location.href="admin_announcement.php"; }
</script>

</body>
</html>
