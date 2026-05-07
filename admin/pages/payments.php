<?php
require_once "../includes/db.php"; 

// DELETE
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM payments WHERE payment_id=?")
        ->execute([$_GET['delete']]);

    header("Location: admin-dashboard.php?page=payments");
    exit;
}

// SAVE
if (isset($_POST['save'])) {

    $appointment_id = $_POST['appointment_id'];
    $amount = $_POST['amount'];

    if ($_POST['id'] == "") {
        $pdo->prepare("INSERT INTO payments (appointment_id, amount) VALUES (?, ?)")
            ->execute([$appointment_id, $amount]);
    } else {
        $pdo->prepare("UPDATE payments SET appointment_id=?, amount=? WHERE payment_id=?")
            ->execute([$appointment_id, $amount, $_POST['id']]);
    }

    header("Location: admin-dashboard.php?page=payments");
    exit;
}

// EDIT
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE payment_id=?");
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
?>

<h2>Payments</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['payment_id'] ?? '' ?>">

    <input type="number" name="appointment_id" placeholder="Appointment ID"
           value="<?= $edit['appointment_id'] ?? '' ?>" required>

    <input type="number" step="0.01" name="amount" placeholder="Amount"
           value="<?= $edit['amount'] ?? '' ?>" required>

    <button name="save">Save</button>
</form>

<hr>

<table border="1" width="100%">
<tr>
    <th>ID</th><th>Appointment</th><th>Amount</th><th>Date</th><th>Action</th>
</tr>

<?php
$data = $pdo->query("SELECT * FROM payments ORDER BY payment_id DESC");
while ($row = $data->fetch()):
?>
<tr>
    <td><?= $row['payment_id'] ?></td>
    <td><?= $row['appointment_id'] ?></td>
    <td><?= $row['amount'] ?></td>
    <td><?= $row['payment_date'] ?></td>
    <td>
        <a href="?page=payments&edit=<?= $row['payment_id'] ?>" class="btn edit-btn">Edit</a> |
        <a href="?page=payments&delete=<?= $row['payment_id'] ?>"
           onclick="return confirm('Delete?')" class="btn delete-btn">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>