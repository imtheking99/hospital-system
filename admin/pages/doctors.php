<?php
require_once "../includes/db.php"; 

// ADD DOCTOR
if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    $stmt = $pdo->prepare("INSERT INTO doctors (name, specialization, contact) VALUES (?, ?, ?)");
    $stmt->execute([$name, $specialization, $contact]);

    header("Location: admin-dashboard.php?page=doctors");
    exit;
}

// DELETE DOCTOR
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: admin-dashboard.php?page=doctors");
    exit;
}

// EDIT DOCTOR (LOAD DATA)
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}

// UPDATE DOCTOR
if (isset($_POST['update_doctor'])) {
    $id = $_POST['doctor_id'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    $stmt = $pdo->prepare("UPDATE doctors SET name=?, specialization=?, contact=? WHERE id=?");
    $stmt->execute([$name, $specialization, $contact, $id]);

    header("Location: admin-dashboard.php?page=doctors");
    exit;
}
?>

<h2>Doctors Management</h2>

<!-- ADD / EDIT FORM -->
<form method="POST" style="margin-bottom:20px; padding:15px; background:#fff; border-radius:8px;">

    <input type="hidden" name="id" value="<?= $editData['doctor_id'] ?? '' ?>">

    <input type="text" name="name"
           placeholder="Doctor Name"
           value="<?= $editData['name'] ?? '' ?>"
           required>

    <input type="text" name="specialization"
           placeholder="Specialization"
           value="<?= $editData['specialization'] ?? '' ?>"
           required>

    <input type="text" name="contact"
           placeholder="Contact"
           value="<?= $editData['contact'] ?? '' ?>"
           required>

    <?php if ($editData): ?>
        <button type="submit" name="update_doctor">Update Doctor</button>
        <a href="admin-dashboard.php?page=doctors">Cancel</a>
    <?php else: ?>
        <button type="submit" name="add_doctor">Add Doctor</button>
    <?php endif; ?>

</form>

<!-- ===================== -->
<!-- DOCTORS TABLE -->
<!-- ===================== -->
<table border="1" width="100%" cellpadding="10" style="background:white;">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Specialization</th>
        <th>Contact</th>
        <th>Actions</th>
    </tr>

    <?php
    $stmt = $pdo->query("SELECT * FROM doctors ORDER BY doctor_id DESC");
    while ($row = $stmt->fetch()):
    ?>

    <tr>
        <td><?= $row['doctor_id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['specialization'] ?></td>
        <td><?= $row['contact'] ?></td>
        <td>
            <a href="admin-dashboard.php?page=doctors&edit=<?= $row['doctor_id'] ?>" class="btn edit-btn">Edit</a> |
            <a href="admin-dashboard.php?page=doctors&delete=<?= $row['doctor_id'] ?>"
               onclick="return confirm('Are you sure?')" class="btn delete-btn">Delete</a>
        </td>
    </tr>

    <?php endwhile; ?>
</table>