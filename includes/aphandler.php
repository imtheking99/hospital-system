<?php

session_start();
require_once 'db.php';
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'Patient'
) {

    header("Location: ../index.php");
    exit();
}

if (isset($_POST['book_now'])) {

    $patientId = $_SESSION['user_id'];

    $doctorId = $_POST['doctor_id'];

    $date = $_POST['appointment_date'];

    try {

  $stmt = $pdo->prepare("CALL sp_BookAppointment(?, ?, ?, ?)");
$stmt->execute([
    $patientId,
    $doctorId,
    $date,
    $time
]);


        $stmt->closeCursor();


        header("Location: ../my_appointments.php?status=success");

        exit();

    } catch (PDOException $e) {

        header("Location: ../pdash.php?error=bookingfailed");

        exit();
    }
}

else {

    header("Location: ../pdash.php");

    exit();
}
?>

