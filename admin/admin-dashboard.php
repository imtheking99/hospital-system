<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            width: 100%;
            background: #f4f6f8;
            min-height: 100vh;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="sidebar">
    <h3 style="text-align:center;">Admin Panel</h3>

    <a href="admin-dashboard.php?page=dashboard">Dashboard</a>
    <a href="admin-dashboard.php?page=doctors">Doctors</a>
    <a href="admin-dashboard.php?page=appointments">Appointments</a>
    <a href="admin-dashboard.php?page=payments">Payments</a>
     <a href="admin-dashboard.php?page=users">Users</a>

</div>

<div class="content">
    <div class="card">

        <?php
        if ($page == 'dashboard') {
            include "pages/dashboard.php";
        } elseif ($page == 'doctors') {
            include "pages/doctors.php";
        } elseif ($page == 'appointments') {
            include "pages/appointments.php";
        } elseif ($page == 'payments') {
            include "pages/payments.php";
        }elseif ($page == 'users') {
            include "pages/users.php";
        }else {
            echo "Page not found!";
        }
        ?>

    </div>
</div>

</body>
</html>