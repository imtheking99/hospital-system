<?php
session_start();
require_once 'db.php';

// Check if user is Admin
if ($_SESSION['role'] !== 'Admin') {
    die("Unauthorized Access");
}

if (isset($_GET['id'])) {
    $doctorId = $_GET['id'];

    // Using Transaction for safe deletion if needed
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("DELETE FROM doctors WHERE doctor_id = ?");
        $stmt->execute([$doctorId]);
        
        $pdo->commit();
        header("deldoctor.php?deleted=true");
    } catch (Exception $e) {
        $pdo->rollBack();
        header("deldoctor.php?error=failed");
    }
}
?>