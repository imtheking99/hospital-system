<?php
session_start();
require_once '../includes/db.php';

if (isset($_POST['process_payment'])) {
    $appointment_id = $_POST['appointment_id'];
    $amount = 500.00; // fixed fee for specialists

    try {
        // Calling the Stored Procedure (Tier 3)
        $stmt = $pdo->prepare("CALL sp_CompletePayment(?, ?)");
        $stmt->execute([$appointment_id, $amount]);

        header("Location: ../my_appointments.php?status=paid");
    } catch (PDOException $e) {
        header("Location: ../checkout.php?error=payment_failed");
    }
}
?>