<?php
require_once __DIR__ . '/db.php';

if (isset($_POST['register_btn'])) {
    // 1. Server-side validation
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($password)) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }

    // 2. Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 3. Use Prepared Statements (Mandatory Rule)
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $role]);

        header("Location: ../index.php?signup=success");
    } catch (PDOException $e) {
        // Check for duplicate username
        header("Location: ../register.php?error=usertaken");
    }
}