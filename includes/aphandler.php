<?php
session_start();
require_once 'db.php';

// Check if user is logged in and is a patient
if (isset($_POST['book_now']) && $_SESSION['role'] == 'Patient') {
    $patientId = $_SESSION['user_id'];
    $doctorId = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];

    try {
        // 1. Execute the Stored Procedure
        $stmt = $pdo->prepare("CALL sp_BookAppointment(?, ?, ?)");
        $stmt->execute([$patientId, $doctorId, $date]);
        
        // 2. Fetch the ID of the appointment we just created
        // We use a query to get the most recent appointment for this patient
        $stmt_id = $pdo->prepare("SELECT appointment_id FROM appointments WHERE patient_id = ? ORDER BY appointment_id DESC LIMIT 1");
        $stmt_id->execute([$patientId]);
        $result = $stmt_id->fetch();
        $app_id = $result['appointment_id'];

        // 3. Redirect to checkout with the app_id in the URL
        // This prevents the "Undefined array key" error on the payment page
        header("Location: ../payment/checkout.php?app_id=" . $app_id);
        exit();

    } catch (Exception $e) {
        // Log error and redirect back to dashboard
        header("Location: ../pdash.php?error=bookingfailed");
        exit();
    }
}
?>