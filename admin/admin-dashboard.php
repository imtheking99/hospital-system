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
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}

/* ===== TOP NAVBAR ===== */
.main-nav {
    width: calc(100% - 50px);
    height: 60px;
    background: linear-gradient(90deg, #1e3c72, #2a5298);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 25px;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 15px;
    margin: 0;
    padding: 0;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 5px;
    transition: 0.3s;
}

.nav-links li a:hover {
    background: rgba(255,255,255,0.2);
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 220px;
    height: calc(100vh - 60px); /* navbar height remove */
    background: #2c3e50;
    color: white;
    position: fixed;
    top: 60px; /* start below navbar */
    left: 0;
    padding-top: 20px;
    overflow-y: auto;
    box-shadow: 2px 0 8px rgba(0,0,0,0.1);
}

.sidebar h3 {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px 18px;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #34495e;
    padding-left: 25px;
}

/* ===== CONTENT AREA ===== */
.content {
    margin-left: 220px;
    margin-top: 60px; /* navbar space */
    padding: 20px;
    min-height: calc(100vh - 60px);
    background: #f4f6f8;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
    </style>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<nav class="main-nav">
    <div class="logo">City Care Hospital</div>

    <ul class="nav-links">
        <li><a href="admin-dashboard.php?page=dashboard">Dashboard</a></li>
        <li><a href="../includes/logout.php">Logout</a></li>
    </ul>
</nav>

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