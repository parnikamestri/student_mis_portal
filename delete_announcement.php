<?php
include "DB.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $delete = "DELETE FROM announcements_admin WHERE announcement_id='$id'";
    mysqli_query($conn, $delete);
}

header("Location: admin_view_announcements.php");
exit();
?>
