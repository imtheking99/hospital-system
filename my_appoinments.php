<?php
session_start();

// Database connection details (Replace with your actual connection)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hospital_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$message = "";

// --- CANCELLATION LOGIC ---
if (isset($_POST['cancel_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    
    // Update the status to 'Cancelled'
    $cancel_query = "UPDATE appointments SET status = 'Cancelled' WHERE id = ? AND patient_id = ?";
    $stmt = $conn->prepare($cancel_query);
    $stmt->bind_param("ii", $appointment_id, $patient_id);
    
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Appointment cancelled successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error cancelling appointment.</div>";
    }
    $stmt->close();
}

// --- FETCH APPOINTMENTS LOGIC  ---
$fetch_query = "SELECT id, specialist_name, appointment_date, status FROM appointments WHERE patient_id = ? ORDER BY appointment_date DESC";
$stmt = $conn->prepare($fetch_query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments - City Care Hospital</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(to bottom right, #7b61ff, #a67cff); color: #333; margin: 0; padding: 20px; min-height: 100vh;}
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f4f4f4; color: #5a32fa; }
        .btn-cancel { background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; }
        .btn-cancel:hover { background-color: #c82333; }
        .status-scheduled { color: green; font-weight: bold; }
        .status-cancelled { color: red; font-weight: bold; }
        .header-links a { margin-right: 15px; color: #5a32fa; text-decoration: none; font-weight: bold;}
    </style>
</head>
<body>

<div class="container">
    <div class="header-links" style="margin-bottom: 20px; text-align: right;">
        <a href="pdash.php">Book Appointment</a>
        <a href="logout.php" style="background-color: #dc3545; color: white; padding: 8px 15px; border-radius: 5px;">Logout</a>
    </div>

    <h2 style="color: #5a32fa; text-align: center;">My Appointments</h2>
    
    <?php echo $message; ?>

    <table>
        <thead>
            <tr>
                <th>Specialist</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $statusClass = ($row['status'] == 'Cancelled') ? 'status-cancelled' : 'status-scheduled';
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['specialist_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                    echo "<td class='{$statusClass}'>" . htmlspecialchars($row['status']) . "</td>";
                    
                    echo "<td>";
                    // Only show cancel button if it is not already cancelled
                    if ($row['status'] != 'Cancelled') {
                        echo "<form method='POST' action='' onsubmit=\"return confirm('Are you sure you want to cancel this appointment?');\">
                                <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
                                <button type='submit' name='cancel_appointment' class='btn-cancel'>Cancel</button>
                              </form>";
                    } else {
                        echo "-";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align: center;'>No appointments found. </td></tr>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>