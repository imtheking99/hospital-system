<?php
require_once '../includes/db.php';
$app_id = $_GET['app_id'];

// Hard delete the pending appointment if they back out
$stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id = ? AND status = 'Pending'");
$stmt->execute([$app_id]);

header("Location: ../pdash.php");
exit();
?>