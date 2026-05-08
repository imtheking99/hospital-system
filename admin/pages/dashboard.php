<?php

require_once "../includes/db.php";

/* =========================
   TOTAL APPOINTMENTS
========================= */

$totalAppointments = $pdo->query("
    SELECT COUNT(*) 
    FROM appointments
")->fetchColumn();

/* =========================
   TOTAL PAYMENTS
========================= */

$totalPayments = $pdo->query("
    SELECT IFNULL(SUM(amount),0)
    FROM payments
")->fetchColumn();

/* =========================
   TOTAL DOCTORS
========================= */

$totalDoctors = $pdo->query("
    SELECT COUNT(*)
    FROM doctors
")->fetchColumn();

/* =========================
   TOTAL PATIENTS
========================= */

$totalPatients = $pdo->query("
    SELECT COUNT(*)
    FROM users
    WHERE role='Patient'
")->fetchColumn();

/* =========================
   PENDING APPOINTMENTS
========================= */

$pendingAppointments = $pdo->query("
    SELECT COUNT(*)
    FROM appointments
    WHERE status='Pending'
")->fetchColumn();

/* =========================
   CONFIRMED APPOINTMENTS
========================= */

$confirmedAppointments = $pdo->query("
    SELECT COUNT(*)
    FROM appointments
    WHERE status='Confirmed'
")->fetchColumn();

/* =========================
   CANCELLED APPOINTMENTS
========================= */

$cancelledAppointments = $pdo->query("
    SELECT COUNT(*)
    FROM appointments
    WHERE status='Cancelled'
")->fetchColumn();

?>

<style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Segoe UI',sans-serif;
    }

    body{
        background:#f4f7fb;
    }

    .dashboard-title{
        font-size:32px;
        font-weight:bold;
        margin-bottom:10px;
        color:#0b3b5f;
    }

    .dashboard-subtitle{
        color:Black;
        margin-bottom:30px;
    }

    /* =========================
       GRID
    ========================= */

    .dashboard-grid{

        display:grid;

        grid-template-columns:
        repeat(auto-fit,minmax(250px,1fr));

        gap:25px;
    }

    /* =========================
       CARDS
    ========================= */

    .dashboard-card{

        background:white;

        border-radius:20px;

        padding:25px;

        box-shadow:0 10px 25px rgba(0,0,0,0.08);

        transition:0.3s;
    }

    .dashboard-card:hover{

        transform:translateY(-5px);

        box-shadow:0 15px 35px rgba(0,0,0,0.12);
    }

    .card-title{

        font-size:16px;

        color:Black;

        margin-bottom:15px;
    }

    .card-value{

        font-size:38px;

        font-weight:bold;

        color:#0b3b5f;
    }

    /* =========================
       COLORS
    ========================= */

    .appointments{
        border-left:8px solid #2196f3;
    }

    .payments{
        border-left:8px solid #4caf50;
    }

    .doctors{
        border-left:8px solid #9c27b0;
    }

    .patients{
        border-left:8px solid #ff9800;
    }

    .pending{
        border-left:8px solid #ffc107;
    }

    .confirmed{
        border-left:8px solid #28a745;
    }

    .cancelled{
        border-left:8px solid #dc3545;
    }

    /* =========================
       MONEY TEXT
    ========================= */

    .money{
        color:#28a745;
    }

</style>

<div class="dashboard-container">

    <h2 class="dashboard-title">
        Admin Dashboard
    </h2>

    <p class="dashboard-subtitle">
        Welcome to City Care Hospital Management System
    </p>

    <div class="dashboard-grid">

        <!-- TOTAL APPOINTMENTS -->

        <div class="dashboard-card appointments">

            <div class="card-title">
                Total Appointments
            </div>

            <div class="card-value">
                <?php echo $totalAppointments; ?>
            </div>

        </div>

        <!-- TOTAL PAYMENTS -->

        <div class="dashboard-card payments">

            <div class="card-title">
                Total Payments
            </div>

            <div class="card-value money">
                Rs. <?php echo number_format($totalPayments,2); ?>
            </div>

        </div>

        <!-- TOTAL DOCTORS -->

        <div class="dashboard-card doctors">

            <div class="card-title">
                Total Doctors
            </div>

            <div class="card-value">
                <?php echo $totalDoctors; ?>
            </div>

        </div>

        <!-- TOTAL PATIENTS -->

        <div class="dashboard-card patients">

            <div class="card-title">
                Total Patients
            </div>

            <div class="card-value">
                <?php echo $totalPatients; ?>
            </div>

        </div>

        <!-- PENDING -->

        <div class="dashboard-card pending">

            <div class="card-title">
                Pending Appointments
            </div>

            <div class="card-value">
                <?php echo $pendingAppointments; ?>
            </div>

        </div>

        <!-- CONFIRMED -->

        <div class="dashboard-card confirmed">

            <div class="card-title">
                Confirmed Appointments
            </div>

            <div class="card-value">
                <?php echo $confirmedAppointments; ?>
            </div>

        </div>

        <!-- CANCELLED -->

        <div class="dashboard-card cancelled">

            <div class="card-title">
                Cancelled Appointments
            </div>

            <div class="card-value">
                <?php echo $cancelledAppointments; ?>
            </div>

        </div>

    </div>

</div>