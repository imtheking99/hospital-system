<?php
session_start();
require_once 'db.php';

if (isset($_POST['book_now']) && $_SESSION['role'] == 'Patient') {
    $patientId = $_SESSION['user_id'];
    $doctorId = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];

    try {
        // Calling a MySQL Stored Procedure
        $stmt = $pdo->prepare("CALL sp_BookAppointment(?, ?, ?)");
        $stmt->execute([$patientId, $doctorId, $date]);
        
        header("Location: ../pdash.php?success=bookingconfirmed");
    } catch (Exception $e) {
        // Handle database errors or trigger failures
        header("Location: ../pdash.php?error=bookingfailed");
    }
}
?>