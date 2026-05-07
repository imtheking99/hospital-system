<?php
session_start();

require_once 'includes/db.php'; 

// Verify user authentication and authorization
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: index.php");
    exit();
}

$patient_id = $_SESSION['user_id'];
$status_message = "";

// APPOINTMENT CANCELLATION LOGIC 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    
    try {
        // Execute update query to modify appointment status
        $cancel_sql = "UPDATE appointments SET status = 'Cancelled' 
                       WHERE appointment_id = ? AND patient_id = ?";
        $cancel_stmt = $pdo->prepare($cancel_sql);
        
        if ($cancel_stmt->execute([$appointment_id, $patient_id])) {
            $status_message = "<div class='alert success'>Appointment cancelled successfully.</div>";
        } else {
            $status_message = "<div class='alert error'>Failed to cancel appointment. Please try again.</div>";
        }
    } catch (PDOException $e) {
        // Log error and notify user of system failure
        $status_message = "<div class='alert error'>System Error: " . $e->getMessage() . "</div>";
    }
}

// DATA RETRIEVAL LOGIC 
try {
    /**
     * Fetch patient appointments using the vw_appointmentsummary database view.
     *his follows the 3-Tier approach by offloading complex joins to the Data Layer.
     */
    $fetch_sql = "SELECT appointment_id, doctor_name, appointment_date, status 
                  FROM vw_appointmentsummary 
                  WHERE patient_name = (SELECT username FROM users WHERE user_id = ?) 
                  ORDER BY appointment_date DESC";
    
    $stmt = $pdo->prepare($fetch_sql);
    $stmt->execute([$patient_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Data Retrieval Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | City Care Hospital</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h2 { color: #5a32fa; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #333; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.85em; text-transform: uppercase; }
        .scheduled { background: #e1f5fe; color: #0288d1; }
        .cancelled { background: #ffebee; color: #c62828; }
        .btn-cancel { background: #ff5252; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; transition: 0.3s; }
        .btn-cancel:hover { background: #d32f2f; }
        .nav-links { text-align: right; margin-bottom: 20px; }
        .nav-links a { text-decoration: none; color: #5a32fa; font-weight: bold; margin-left: 15px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-links">
        <a href="pdash.php">Dashboard</a>
        <a href="includes/logout.php" style="color: #ff5252;">Sign Out</a>
    </div>

    <h2>My Appointment History</h2>

    <?php echo $status_message; ?>

    <table>
        <thead>
            <tr>
                <th>Medical Specialist</th>
                <th>Scheduled Date</th>
                <th>Current Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($appointments) > 0): ?>
                <?php foreach ($appointments as $row): ?>
                    <tr>
                        <td><strong>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['status'] !== 'Cancelled'): ?>
                                <form method="POST" onsubmit="return confirm('Confirm appointment cancellation?');">
                                    <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                    <button type="submit" name="cancel_appointment" class="btn-cancel">Cancel</button>
                                </form>
                            <?php else: ?>
                                <span style="color: #999;">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #777;">
                        No appointment records found in your profile.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>