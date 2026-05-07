<?php
session_start();
require_once 'db.php';

if (isset($_POST['update_profile'])) {
    $userId = $_SESSION['user_id'];
    $newUsername = trim($_POST['username']);
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing

    // Validation
    if (empty($newUsername) || empty($_POST['password'])) {
        header("Location: ../profile.php?error=emptyfields");
        exit();
    }

    try {
        // Calling the 3rd Stored Procedure
        $stmt = $pdo->prepare("CALL sp_UpdatePatientProfile(?, ?, ?)");
        $stmt->execute([$userId, $newUsername, $newPassword]);
        
        header("Location: ../profile.php?status=updated");
    } catch (PDOException $e) {
        header("Location: ../profile.php?error=usertaken");
    }
}