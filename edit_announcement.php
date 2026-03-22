<?php
include "DB.php";
include "faculty_auth.php";


if(!isset($_GET['id'])){
    header("Location: announcement.php");
    exit;
}

$id = intval($_GET['id']);



$stmt = $conn->prepare("SELECT * FROM announcement_faculty WHERE announcement_id=? AND faculty_id=?");
$stmt->bind_param("ii", $id, $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Announcement Not Found or Not Authorized";
    exit;
}

$a = $result->fetch_assoc();


$error = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $message = $_POST['message'] ?? '';
    $audience = $_POST['audience'] ?? 'All';
    $class_id = !empty($_POST['class']) ? intval($_POST['class']) : NULL;


    $file_path = $a['file_path'];
    if(isset($_FILES['file']) && $_FILES['file']['name'] != ''){
        $uploadDir = "uploads/";
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = time().'_'.basename($_FILES['file']['name']);
        $targetFile = $uploadDir.$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
            $file_path = $targetFile;
        }
    }


    $stmt = $conn->prepare("
        UPDATE announcement_faculty 
        SET title=?, category=?, message=?, file_path=?, audience_type=?, class_id=? 
        WHERE announcement_id=? AND faculty_id=?
    ");
    $stmt->bind_param("ssssiiii", $title, $category, $message, $file_path, $audience, $class_id, $id, $faculty_id);

    if($stmt->execute()){
        header("Location: view_announcement.php?id=$id&updated=1");
        exit;
    } else {
        $error = "Error updating: ".$stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Announcement</title>
<style>
:root{
    --primary:#4f6fa1;
    --bg:#f4f7f9;
    --border:#d6e2ea;
    --text:#2c3e50;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI, Arial;}
body{background:var(--bg);color:var(--text);}
.header{background:#3f6fa1;color:#fff;padding:16px 28px;display:flex;justify-content:space-between;}
.header span{cursor:pointer;}
.container{display:flex;}
.sidebar{width:260px;background:#eef3f7;border-right:1px solid var(--border);}
.sidebar a{display:block;padding:18px 22px;border-bottom:1px solid #dbe6ed;text-decoration:none;color:#2c3e50;font-size:14px;font-weight:600;}
.sidebar a:hover{background:#dde8f0;}
.sidebar a.active{background:#dde8f0;border-left:4px solid var(--primary);}
.content{flex:1;background:#fff;margin:25px;padding:35px;border-radius:10px;border:1px solid #dfe6ec;box-shadow:0 4px 12px rgba(0,0,0,0.05);}
.content h2{font-size:22px;border-bottom:2px solid #e6eef4;padding-bottom:10px;}
label{display:block;margin-top:15px;font-weight:600;}
input[type=text], textarea, select{width:60%;padding:8px;border:1px solid #cfd8df;border-radius:5px;font-size:14px;}
textarea{height:100px;resize:none;}
input:focus, textarea:focus, select:focus{border-color:#3f6fa1;outline:none;}
.btn{background:#3f6fa1;color:white;padding:10px 26px;border-radius:25px;border:none;margin-top:20px;cursor:pointer;}
.btn:hover{background:#345f8c;}
.cancel{background:#7f8c8d;margin-left:10px;}
.cancel:hover{background:#6c7a7b;}
</style>
</head>
<body>

<div class="header">
<h2>Edit Announcement</h2>
<span onclick="window.location.href='logout.php'">⇨ Sign Out</span>
</div>

<div class="container">
<div class="sidebar">
 <a href="faculty_attendance_select.php">ATTENDANCE</a>
 <a href="marks_entry.php">MARKS ENTRY</a>
 <a href="reports.php">REPORTS</a>
 <a href="notifications.php">NOTIFICATIONS</a>
 <a href="class_wise_students.php">CLASS-WISE STUDENT LIST</a>
 <a href="announcement.php" class="active">ANNOUNCEMENTS</a>
</div>

<div class="content">
<h2>Edit Announcement</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($a['title']); ?>" required>

    <label>Category:</label>
    <select name="category" required>
        <option value="Academic" <?php if($a['category']=='Academic') echo "selected"; ?>>Academic</option>
        <option value="Class" <?php if($a['category']=='Class') echo "selected"; ?>>Class</option>
        <option value="General" <?php if($a['category']=='General') echo "selected"; ?>>General</option>
    </select>

    <label>Message:</label>
    <textarea name="message" required><?php echo htmlspecialchars($a['message']); ?></textarea>

    <label>Attach File (Optional):</label>
    <input type="file" name="file">
    <?php if(!empty($a['file_path'])){ ?>
        <div>Current File: <a href="<?php echo $a['file_path']; ?>" target="_blank">View</a></div>
    <?php } ?>

    <label>Audience:</label>
    <select name="audience" required>
        <option value="All" <?php if($a['audience_type']=='All') echo "selected"; ?>>All Students</option>
        <option value="Specific" <?php if($a['audience_type']=='Specific') echo "selected"; ?>>Specific Class</option>
    </select>

    <label>Class (if Specific):</label>
    <select name="class">
        <option value="">--Select Class--</option>
        <?php
        $res = $conn->query("SELECT class_id, class_name FROM class");
        while($row = $res->fetch_assoc()){
            $sel = ($row['class_id']==$a['class_id']) ? "selected" : "";
            echo "<option value='{$row['class_id']}' $sel>{$row['class_name']}</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn">Update Announcement</button>
    <button type="button" class="btn cancel" onclick="window.location.href='view_announcement.php?id=<?php echo $id; ?>'">Cancel</button>
</form>

</div>
</div>

</body>
</html>