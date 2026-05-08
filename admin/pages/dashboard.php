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

/* =========================
   REVENUE BY DOCTOR
========================= */

$revenueData = $pdo->query("
    SELECT *
    FROM vw_revenuebydoctor
    ORDER BY total_revenue DESC
");

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

/* =========================
   DASHBOARD HEADER
========================= */

.dashboard-title{

    font-size:34px;

    font-weight:bold;

    margin-bottom:10px;

    color:#0b3b5f;
}

.dashboard-subtitle{

    color:#555;

    margin-bottom:35px;

    font-size:16px;
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

    border-radius:22px;

    padding:28px;

    box-shadow:0 10px 25px rgba(0,0,0,0.08);

    transition:0.3s;
}

.dashboard-card:hover{

    transform:translateY(-6px);

    box-shadow:0 18px 35px rgba(0,0,0,0.12);
}

.card-title{

    font-size:16px;

    color:#666;

    margin-bottom:18px;
}

.card-value{

    font-size:40px;

    font-weight:bold;

    color:#0b3b5f;
}

/* =========================
   CARD COLORS
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
   MONEY
========================= */

.money{
    color:#28a745;
}

/* =========================
   REVENUE SECTION
========================= */

.revenue-section{

    margin-top:45px;

    background:white;

    border-radius:22px;

    padding:28px;

    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.revenue-title{

    font-size:26px;

    color:#0b3b5f;

    margin-bottom:25px;
}

/* =========================
   TABLE
========================= */

.table-wrapper{
    overflow-x:auto;
}

.revenue-table{

    width:100%;

    border-collapse:collapse;

    overflow:hidden;
}

.revenue-table thead{

    background:#0b3b5f;

    color:white;
}

.revenue-table th{

    padding:16px;

    text-align:left;

    font-size:15px;
}

.revenue-table td{

    padding:16px;

    border-bottom:1px solid #e8edf3;

    color:#333;
}

.revenue-table tbody tr:hover{

    background:#f8fbff;
}

.revenue-money{

    color:#28a745;

    font-weight:bold;
}

/* =========================
   EMPTY DATA
========================= */

.empty-row{

    text-align:center;

    padding:30px;

    color:#888;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .dashboard-title{
        font-size:28px;
    }

    .card-value{
        font-size:30px;
    }

    .dashboard-grid{
        grid-template-columns:1fr;
    }

    .revenue-table th,
    .revenue-table td{

        padding:12px;

        font-size:14px;
    }
}

</style>

<div class="dashboard-container">

    <!-- HEADER -->

    <h2 class="dashboard-title">
        Admin Dashboard
    </h2>

    <p class="dashboard-subtitle">
        Welcome to City Care Hospital Management System
    </p>

    <!-- CARDS -->

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
                Total Revenue
            </div>

            <div class="card-value money">

                Rs.
                <?php echo number_format($totalPayments,2); ?>

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

    <div class="revenue-section">

        <h3 class="revenue-title">
            Revenue By Doctors
        </h3>

        <div class="table-wrapper">

            <table class="revenue-table">

                <thead>

                    <tr>

                        <th>Doctor Name</th>

                        <th>Specialization</th>

                        <th>Total Appointments</th>

                        <th>Total Revenue</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if($revenueData->rowCount() > 0): ?>

                        <?php while($row = $revenueData->fetch()): ?>

                            <tr>

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $row['doctor_name']
                                    );
                                    ?>

                                </td>

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $row['specialization']
                                    );
                                    ?>

                                </td>

                                <td>

                                    <?php
                                    echo $row['total_appointments'];
                                    ?>

                                </td>

                                <td class="revenue-money">

                                    Rs.

                                    <?php
                                    echo number_format(
                                        $row['total_revenue'],
                                        2
                                    );
                                    ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="4"
                                class="empty-row">

                                No revenue data available.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>