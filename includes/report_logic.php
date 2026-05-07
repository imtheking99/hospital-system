<?php
require_once __DIR__ . '/db.php';

// 1. Fetch Summary Stats for the stat-boxes
$stmtStats = $pdo->query("SELECT COUNT(*) as total FROM appointments WHERE appointment_date = CURDATE()");
$todayCount = $stmtStats->fetch()['total'];

$stmtDocs = $pdo->query("SELECT COUNT(*) as total FROM doctors");
$doctorCount = $stmtDocs->fetch()['total'];

// 2. Fetch Detailed Log from the MySQL View (Requirement: View must be used)
$stmtLog = $pdo->query("SELECT * FROM vw_AppointmentSummary ORDER BY appointment_date DESC");
$appointments = $stmtLog->fetchAll();
?>