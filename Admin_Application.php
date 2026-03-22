<?php
include "admin_auth.php";
include "DB.php";


if(!isset($_SESSION['admin_name']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['admin_name'];


if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = [
        1 => ["roll"=>3201,"name"=>"Manali Juvale","branch"=>"COMPUTER","year"=>"FY","type"=>"Bonafide","status"=>"Approved","date"=>"2025-01-05"],
        2 => ["roll"=>3202,"name"=>"Parnika Mestri","branch"=>"COMPUTER","year"=>"TY","type"=>"LC","status"=>"Pending","date"=>"2025-01-08"],
        3 => ["roll"=>3203,"name"=>"Vaidehi Medhekar","branch"=>"COMPUTER","year"=>"FY","type"=>"Bonafide","status"=>"Rejected","date"=>"2025-01-10"],
        4 => ["roll"=>3201,"name"=>"Mayuri Bane","branch"=>"COMPUTER","year"=>"SY","type"=>"Transcript","status"=>"Approved","date"=>"2025-01-12"],
        5 => ["roll"=>3204,"name"=>"Shivani Sawant","branch"=>"COMPUTER","year"=>"TY","type"=>"Scholarship","status"=>"Pending","date"=>"2025-01-14"],
    ];
}

$applications = $_SESSION['applications'];


$searchRoll   = $_GET['search_roll'] ?? '';
$filterBranch = $_GET['filter_branch'] ?? '';
$filterYear   = $_GET['filter_year'] ?? '';
$filterStatus = $_GET['filter_status'] ?? '';

$filteredApplications = array_filter($applications, function($a) use ($searchRoll,$filterBranch,$filterYear,$filterStatus){
    if ($searchRoll && $a['roll'] != $searchRoll) return false;
    if ($filterBranch && $a['branch'] != $filterBranch) return false;
    if ($filterYear && $a['year'] != $filterYear) return false;
    if ($filterStatus && $a['status'] != $filterStatus) return false;
    return true;
});



$total = count($applications);
$approved = $rejected = $pending = 0;

foreach ($applications as $a) {
    if ($a['status']=="Approved") $approved++;
    if ($a['status']=="Rejected") $rejected++;
    if ($a['status']=="Pending")  $pending++;
}
?>