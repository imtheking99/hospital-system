<?php
require_once "../includes/db.php"; 

// DELETE
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM users WHERE user_id=?")
        ->execute([$_GET['delete']]);

    header("Location: admin-dashboard.php?page=users");
    exit;
}

// SAVE
if (isset($_POST['save'])) {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($_POST['id'] == "") {
        $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")
            ->execute([$username, $password, $role]);
    } else {
        $pdo->prepare("UPDATE users SET username=?, role=? WHERE user_id=?")
            ->execute([$username, $role, $_POST['id']]);
    }

    header("Location: admin-dashboard.php?page=users");
    exit;
}

// EDIT
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
?>

<h2>Users</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['user_id'] ?? '' ?>">

    <input type="text" name="username" placeholder="Username"
           value="<?= $edit['username'] ?? '' ?>" required>

    <input type="password" name="password" placeholder="Password">

    <select name="role">
        <option>Admin</option>
        <option>Patient</option>
        <option>Doctor</option>
    </select>

    <button name="save">Save</button>
</form>

<hr>

<table border="1" width="100%">
<tr>
    <th>ID</th><th>Username</th><th>Role</th><th>Action</th>
</tr>

<?php
$data = $pdo->query("SELECT * FROM users ORDER BY user_id DESC");
while ($row = $data->fetch()):
?>
<tr>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['role'] ?></td>
    <td>
        <a href="?page=users&edit=<?= $row['user_id'] ?>" class="btn edit-btn">Edit</a> |
        <a href="?page=users&delete=<?= $row['user_id'] ?>"
           onclick="return confirm('Delete?')" class="btn delete-btn">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>