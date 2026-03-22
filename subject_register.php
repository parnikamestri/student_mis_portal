
<?php
include("DB.php");
include("faculty_auth.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $subject_abbr = $_POST['subject_abbr'];
    $program_id   = $_POST['program_id'];
    $semester_id  = $_POST['semester_id'];
    $course_category = $_POST['course_category'];

    $cl_hours = $_POST['cl_hours'];
    $tl_hours = $_POST['tl_hours'];
    $ll_hours = $_POST['ll_hours'];
    $iks_hours = $_POST['iks_hours'];
    $slh_hours = $_POST['slh_hours'];
    $nlh_hours = $_POST['nlh_hours'];

    $credits = $_POST['credits'];
    $paper_duration = $_POST['paper_duration'];

    $subject_type = $_POST['subject_type'];
    $total_marks = $_POST['total_marks'];
    $passing_marks = $_POST['passing_marks'];

    $fa_th_marks = $_POST['fa_th_marks'];
    $sa_th_marks = $_POST['sa_th_marks'];
    $fa_pr_marks = $_POST['fa_pr_marks'];
    $sa_pr_marks = $_POST['sa_pr_marks'];
    $sla_marks = $_POST['sla_marks'];

    $theory_min_marks = $_POST['theory_min_marks'];
    $practical_min_marks = $_POST['practical_min_marks'];
    $sla_min_marks = $_POST['sla_min_marks'];

    $exam_type = $_POST['exam_type'];

    
    $check = mysqli_query($conn, "SELECT * FROM subject WHERE subject_code='$subject_code'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>
                alert('Subject Code Already Exists!');
                window.history.back();
              </script>";
        exit;
    }

    
    $query = "INSERT INTO subject 
    (subject_name, subject_code, abbr, program_id, semester_id,
     course_category, cl_hours, tl_hours, ll_hours, iks_hours,
     slh_hours, nlh_hours, credits, paper_duration,
     subject_type, total_marks, passing_marks,
     fa_th_marks, sa_th_marks,
     fa_pr_marks, sa_pr_marks, sla_marks,
     theory_min_marks, practical_min_marks, sla_min_marks,
     exam_type, status)
    VALUES
    ('$subject_name', '$subject_code', '$subject_abbr', '$program_id', '$semester_id',
     '$course_category', '$cl_hours', '$tl_hours', '$ll_hours', '$iks_hours',
     '$slh_hours', '$nlh_hours', '$credits', '$paper_duration',
     '$subject_type', '$total_marks', '$passing_marks',
     '$fa_th_marks', '$sa_th_marks',
     '$fa_pr_marks', '$sa_pr_marks', '$sla_marks',
     '$theory_min_marks', '$practical_min_marks', '$sla_min_marks',
     '$exam_type', 'Active')";

    $result = mysqli_query($conn, $query);

    if($result){
        $subject_id = mysqli_insert_id($conn);

        $selected_exams = $_POST['exam_names'] ?? [];
        $academic_year = date("Y");
        $status = "Active";

        foreach($selected_exams as $exam_name){

           
            if($exam_name == "Unit Test"){

                $examList = ["Unit Test 1","Unit Test 2"];

                foreach($examList as $ex){

                    $checkExam = mysqli_query($conn,"
                        SELECT * FROM exam 
                        WHERE exam_name='$ex'
                        AND subject_id='$subject_id'
                    ");

                    if(mysqli_num_rows($checkExam) == 0){
                        mysqli_query($conn,"
                            INSERT INTO exam
                            (subject_id, exam_name, exam_type, program_id, semester_id, academic_year, status)
                            VALUES
                            ('$subject_id','$ex','$exam_type','$program_id','$semester_id','$academic_year','$status')
                        ");
                    }
                }

            }else{

                
                $checkExam = mysqli_query($conn,"
                    SELECT * FROM exam 
                    WHERE exam_name='$exam_name'
                    AND subject_id='$subject_id'
                ");

                if(mysqli_num_rows($checkExam) == 0){
                    mysqli_query($conn,"
                        INSERT INTO exam
                        (subject_id, exam_name, exam_type, program_id, semester_id, academic_year, status)
                        VALUES
                        ('$subject_id','$exam_name','$exam_type','$program_id','$semester_id','$academic_year','$status')
                    ");
                }

            }
        }

        echo "<script>
                alert('Subject Registered Successfully!');
                window.location.href='hod_dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}
?>
```
