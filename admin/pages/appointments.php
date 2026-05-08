<?php
require_once "../includes/db.php";

/* =========================
   DELETE
========================= */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id=?");
    $stmt->execute([$id]);

    header("Location: admin-dashboard.php?page=appointments");
    exit;
}

/* =========================
   UPDATE STATUS
========================= */

if (isset($_POST['save'])) {

    $appointment_id = $_POST['id'];

    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];

    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    $status = $_POST['status'];

    if ($appointment_id == "") {

        $stmt = $pdo->prepare("
            INSERT INTO appointments
            (
                patient_id,
                doctor_id,
                appointment_date,
                appointment_time,
                status
            )
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $patient_id,
            $doctor_id,
            $date,
            $time,
            $status
        ]);

    } else {

        $stmt = $pdo->prepare("
            UPDATE appointments
            SET
                patient_id=?,
                doctor_id=?,
                appointment_date=?,
                appointment_time=?,
                status=?
            WHERE appointment_id=?
        ");

        $stmt->execute([
            $patient_id,
            $doctor_id,
            $date,
            $time,
            $status,
            $appointment_id
        ]);
    }

    header("Location: admin-dashboard.php?page=appointments");
    exit;
}

/* =========================
   EDIT
========================= */

$edit = null;

if (isset($_GET['edit'])) {

    $stmt = $pdo->prepare("
        SELECT * FROM appointments
        WHERE appointment_id=?
    ");

    $stmt->execute([$_GET['edit']]);

    $edit = $stmt->fetch();
}
?>

<h2>Appointments Management</h2>

<form method="POST">

    <input type="hidden"
           name="id"
           value="<?= $edit['appointment_id'] ?? '' ?>">

    <input type="number"
           name="patient_id"
           placeholder="Patient ID"
           value="<?= $edit['patient_id'] ?? '' ?>"
           required>

    <input type="number"
           name="doctor_id"
           placeholder="Doctor ID"
           value="<?= $edit['doctor_id'] ?? '' ?>"
           required>

    <input type="date"
           name="appointment_date"
           value="<?= $edit['appointment_date'] ?? '' ?>"
           required>

    <input type="time"
           name="appointment_time"
           value="<?= $edit['appointment_time'] ?? '' ?>"
           required>

    <select name="status" required>

        <option value="Pending"
        <?= (($edit['status'] ?? '') == 'Pending') ? 'selected' : '' ?>>
            Pending
        </option>

        <option value="Confirmed"
        <?= (($edit['status'] ?? '') == 'Confirmed') ? 'selected' : '' ?>>
            Confirmed
        </option>

        <option value="Cancelled"
        <?= (($edit['status'] ?? '') == 'Cancelled') ? 'selected' : '' ?>>
            Cancelled
        </option>

    </select>

    <button name="save">
        Save Appointment
    </button>

</form>

<hr>

<table border="1" width="100%" cellpadding="10">

<tr>
    <th>Appointment No</th>
    <th>Patient ID</th>
    <th>Doctor ID</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php

$data = $pdo->query("
    SELECT *
    FROM appointments
    ORDER BY appointment_id DESC
");

while ($row = $data->fetch()):
?>

<tr>

    <td>
        <strong>
            AP-<?= str_pad($row['appointment_id'], 4, "0", STR_PAD_LEFT); ?>
        </strong>
    </td>

    <td><?= $row['patient_id'] ?></td>

    <td><?= $row['doctor_id'] ?></td>

    <td><?= $row['appointment_date'] ?></td>

    <td><?= $row['appointment_time'] ?></td>

    <td>

        <?php if($row['status'] == 'Pending'): ?>

            <span style="color:orange;font-weight:bold;">
                Pending
            </span>

        <?php elseif($row['status'] == 'Confirmed'): ?>

            <span style="color:green;font-weight:bold;">
                Confirmed
            </span>

        <?php else: ?>

            <span style="color:red;font-weight:bold;">
                Cancelled
            </span>

        <?php endif; ?>

    </td>

    <td>

        <a href="?page=appointments&edit=<?= $row['appointment_id'] ?>" class="btn edit-btn">
            Edit
        </a>

        |

        <a href="?page=appointments&delete=<?= $row['appointment_id'] ?>"
           onclick="return confirm('Delete appointment?')" class="btn delete-btn">

            Delete

        </a>

    </td>

</tr>

<?php endwhile; ?>

</table>