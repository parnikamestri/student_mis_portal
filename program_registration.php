<?php
include "DB.php";
include "admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Program Registration</title>

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

    
    .content {
        flex: 1;
        padding: 30px;
         align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .card {
        background-color: #fff;
        width: 520px;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .card h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #555;
    }

    input, select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #5b7fa6;
    }

    .btn {
        width: 100%;
        margin-top: 20px;
        padding: 10px;
        background-color: #5b7fa6;
        border: none;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        border-radius: 25px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #4a6a8c;
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
        <a href="admin_announcement.php">ANNOUNCEMENTS</a>
        <a href="create_profile.php">FACULTY REGISTRATION</a>
        <a href="Department_Registration.php">DEPARTMENT REGISTRATION</a>
        <a href="Semester_Registration.php">SEMESTER REGISTRATION</a>
        <a href="progran_registration.php" class="active">PROGRAM REGISTRATION</a>
    </div>

    
    <div class="content">

        <div class="card">
            <h2>Program Registration</h2>

            <form method="POST" action="program_insert.php">

                <div class="form-group">
                    <label>Department</label>
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
                </div>

                <div class="form-group">
                    <label>Program Name</label>
                    <input type="text" name="program_name" required>
                </div>

                <div class="form-group">
                    <label>Program Code</label>
                    <input type="text" name="program_code">
                </div>

                <div class="form-group">
                    <label>Duration (Years)</label>
                    <input type="number" name="duration_years" min="1" required>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level">
                        <option value="">Select Level</option>
                        <option value="regular">Regular</option>
                        <option value="minority">Minority</option>
                        <option value="both">Both</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Total Semesters</label>
                    <input type="number" name="total_semesters" min="1" required>
                </div>

                <button type="submit" name="register" class="btn">
                    Register Program
                </button>

            </form>
        </div>

    </div>
</div>

</body>
</html>
