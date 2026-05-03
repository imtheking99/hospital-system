<nav class="main-nav">
    <div class="logo">City Care Hospital</div>
    <ul class="nav-links">
        <li><a href="patient_dashboard.php">Book Appointment</a></li>
        <li><a href="my_appointments.php">My Appointments</a></li>
        <li><a href="tier2/logout.php">Logout</a></li>
    </ul>
</nav>

<main class="container">
    <section class="booking-card">
        <h3>Book a New Appointment</h3>
        <form action="tier2/appointment_handler.php" method="POST">
            <label>Select Specialist</label>
            <select name="doctor_id" required>
                <option value="">-- Choose Doctor --</option>
                <!-- PHP will populate this from 'Doctors' table -->
            </select>

            <label>Preferred Date</label>
            <input type="date" name="appointment_date" min="2026-05-03" required>

            <button type="submit" name="book_now">Confirm Booking</button>
        </form>
    </section>
</main>