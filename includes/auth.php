<?php
session_start();
require_once 'db.php';

if (isset($_POST['login_btn'])) {
    // Server-side validation
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }

    // Using Prepared Statements (Strict Rule)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'Admin') {
            header("Location: ../admin_reports.php");
        } else {
            header("Location: ../patient_dashboard.php");
        }
    } else {
        header("Location: ../index.php?error=invalidcredentials");
    }
}
?>