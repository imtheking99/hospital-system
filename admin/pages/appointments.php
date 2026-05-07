<?php
require_once "../includes/db.php"; 

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id=?");
    $stmt->execute([$id]);
    header("Location: admin-dashboard.php?page=appointments");
    exit;
}

// ADD / UPDATE
if (isset($_POST['save'])) {

    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $status = $_POST['status'];

    if ($_POST['id'] == "") {
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$patient_id, $doctor_id, $date, $status]);
    } else {
        $stmt = $pdo->prepare("UPDATE appointments SET patient_id=?, doctor_id=?, appointment_date=?, status=?
                               WHERE appointment_id=?");
        $stmt->execute([$patient_id, $doctor_id, $date, $status, $_POST['id']]);
    }

    header("Location: admin-dashboard.php?page=appointments");
    exit;
}

// EDIT DATA
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_id=?");
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
?>

<h2>Appointments</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['appointment_id'] ?? '' ?>">

    <input type="number" name="patient_id" placeholder="Patient ID"
           value="<?= $edit['patient_id'] ?? '' ?>" required>

    <input type="number" name="doctor_id" placeholder="Doctor ID"
           value="<?= $edit['doctor_id'] ?? '' ?>" required>

    <input type="date" name="appointment_date"
           value="<?= $edit['appointment_date'] ?? '' ?>" required>

    <select name="status">
        <option>Pending</option>
        <option>Confirmed</option>
        <option>Cancelled</option>
    </select>

    <button name="save">Save</button>
</form>

<hr>

<table border="1" width="100%">
<tr>
    <th>ID</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th><th>Action</th>
</tr>

<?php
$data = $pdo->query("SELECT * FROM appointments ORDER BY appointment_id DESC");
while ($row = $data->fetch()):
?>
<tr>
    <td><?= $row['appointment_id'] ?></td>
    <td><?= $row['patient_id'] ?></td>
    <td><?= $row['doctor_id'] ?></td>
    <td><?= $row['appointment_date'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a href="?page=appointments&edit=<?= $row['appointment_id'] ?>" class="btn edit-btn">Edit</a> |
        <a href="?page=appointments&delete=<?= $row['appointment_id'] ?>"
           onclick="return confirm('Delete?')" class="btn delete-btn">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>