<?php
require_once __DIR__ . '/db.php';

if (isset($_POST['register_btn'])) {

    // 1. Get Form Data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Default role
    $role = "Patient";

    // 2. Validation
    if (empty($username) || empty($password)) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }

    // 3. Hash Password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {

        // 4. Insert User
        $stmt = $pdo->prepare(
            "INSERT INTO users (username, password, role)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $username,
            $hashedPassword,
            $role
        ]);

        header("Location: ../index.php?signup=success");
        exit();

    } catch (PDOException $e) {

        // Duplicate username
        header("Location: ../register.php?error=usertaken");
        exit();
    }
}
?>