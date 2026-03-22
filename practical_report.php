<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Profile - Practical Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
        .topbar {
            background-color: #587CA1;
            color: white;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            position: relative;
        }

        
        .back-btn{
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            width:36px;
            height:36px;
            background:rgba(255,255,255,0.18);
            border-radius:8px;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
        }
        .back-btn svg{
            width:18px;
            height:18px;
            stroke:#fff;
        }
        .back-btn:hover{
            background:rgba(255,255,255,0.28);
        }

        .title{
            margin:auto;
        }

        .signout {
            position:absolute;
            right:30px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .center-box {
            height: calc(100vh - 80px);
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-custom {
            background-color: #d8e9ef;
            border-radius: 18px;
            padding: 12px 40px;
            color: black;
            font-size: 18px;
            margin: 0px 60px;
            border: none;
            font-weight: 600;
        }

        .btn-custom:hover {
            background-color: #b7d3df;
        }
    </style>
</head>
<body>


<div class="topbar">


    <a href="marks_entry.php" class="back-btn" title="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
        </svg>
    </a>

    <span class="title">Faculty Profile</span>
    <a href="logout.php" class="signout">➥ Sign Out</a>
</div>

<div class="center-box">
    <a href="lab_manual.php">
        <button class="btn btn-custom">lab manual</button>
    </a>

    <a href="practical_exam.php">
        <button class="btn btn-custom">practical exam</button>
    </a>
</div>

</body>
</html>
