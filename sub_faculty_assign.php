<?php
include "DB.php";

/* ================= AJAX HANDLERS ================= */

if(isset($_POST['action'])){

    /* Load subjects by semester */
    if($_POST['action']=="getSubjects"){
        $sem = $_POST['semester'];
        $q = mysqli_query($conn,"SELECT * FROM subjects WHERE semester='$sem'");
        echo "<option value=''>Select Subject</option>";
        while($s=mysqli_fetch_assoc($q)){
            echo "<option value='{$s['subject_id']}'>{$s['subject_name']}</option>";
        }
        exit;
    }

    /* Check theory / practical */
    if($_POST['action']=="getType"){
        $sid = $_POST['subject_id'];
        $q = mysqli_query($conn,"SELECT has_theory,has_practical FROM subjects WHERE subject_id='$sid'");
        echo json_encode(mysqli_fetch_assoc($q));
        exit;
    }

    /* Assign subject */
    if($_POST['action']=="assign"){
        $sid = $_POST['subject_id'];

        if(!empty($_POST['theory'])){
            mysqli_query($conn,"INSERT INTO subject_assign(subject_id,faculty_id,type)
            VALUES('$sid','{$_POST['theory']}','Theory')");
        }
        if(!empty($_POST['practical'])){
            mysqli_query($conn,"INSERT INTO subject_assign(subject_id,faculty_id,type)
            VALUES('$sid','{$_POST['practical']}','Practical')");
        }
        echo "Subject Assigned Successfully";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Subject Assign</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
select,button{padding:8px;margin:8px}
.box{background:#eee;padding:20px;width:400px}
</style>
</head>

<body>

<h2>SUBJECT ASSIGN TO FACULTY</h2>

<!-- Semester -->
<select id="semester">
    <option value="">Select Semester</option>
    <?php for($i=1;$i<=6;$i++) echo "<option value='$i'>Semester $i</option>"; ?>
</select>

<br>

<!-- Subject -->
<select id="subject">
    <option value="">Select Subject</option>
</select>

<div class="box">

    <!-- Theory -->
    <div id="theory_div" style="display:none;">
        Theory :
        <select id="theory">
            <option value="">Select Faculty</option>
            <?php
            $f=mysqli_query($conn,"SELECT * FROM faculty");
            while($row=mysqli_fetch_assoc($f)){
                echo "<option value='{$row['faculty_id']}'>{$row['faculty_name']}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Practical -->
    <div id="practical_div" style="display:none;">
        Practical :
        <select id="practical">
            <option value="">Select Faculty</option>
            <?php
            $f=mysqli_query($conn,"SELECT * FROM faculty");
            while($row=mysqli_fetch_assoc($f)){
                echo "<option value='{$row['faculty_id']}'>{$row['faculty_name']}</option>";
            }
            ?>
        </select>
    </div>

</div>

<button id="assign">Assign</button>

<script>
/* Semester → Subjects */
$("#semester").change(function(){
    $.post("subject_assign.php",{
        action:"getSubjects",
        semester:$(this).val()
    },function(data){
        $("#subject").html(data);
        $("#theory_div,#practical_div").hide();
    });
});

/* Subject → Theory / Practical */
$("#subject").change(function(){
    $.post("subject_assign.php",{
        action:"getType",
        subject_id:$(this).val()
    },function(res){
        let d = JSON.parse(res);
        d.has_theory==1 ? $("#theory_div").show() : $("#theory_div").hide();
        d.has_practical==1 ? $("#practical_div").show() : $("#practical_div").hide();
    });
});

/* Assign */
$("#assign").click(function(){
    $.post("subject_assign.php",{
        action:"assign",
        subject_id:$("#subject").val(),
        theory:$("#theory").val(),
        practical:$("#practical").val()
    },function(msg){
        alert(msg);
    });
});
</script>

</body>
</html>
