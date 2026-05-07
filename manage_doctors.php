<?php include('tier2/db_config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style3.css">
    <title>Doctor Management</title>
</head>
<body>
    <nav class="main-nav">
        <div class="logo">City Care Hospital</div>
        <ul class="nav-links">
            <li><a href="manage_doctors.php">Manage Doctors</a></li>
            <li><a href="tier2/logout.php">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <!-- Add Doctor Form -->
        <section class="booking-card">
            <h3>Add Doctor</h3>
            <form action="tier2/doctor_handler.php" method="POST">
                <input type="text" name="name" placeholder="Doctor Name" required>
                <input type="text" name="specialization" placeholder="Specialization" required>
                <input type="text" name="contact" placeholder="Contact" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit" name="add_doctor">Save Doctor</button>
            </form>
        </section>

        <!-- Display Doctors Table -->
        <section class="booking-card" style="margin-top:20px;">
            <h3>Current Doctors List</h3>
            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Action</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM doctors");
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['specialization']}</td>
                        <td>
                            <a href='edit_doctor.php?id={$row['id']}'>Edit</a> | 
                            <a href='tier2/doctor_handler.php?delete={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </section>
    </main>
</body>
</html>