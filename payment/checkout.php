<link rel="stylesheet" href="pay_style.css">
<main class="container">
    <section class="booking-card">
        <h3>Secure Checkout</h3>
        <div class="payment-summary">
            <p><strong>Appointment ID:</strong> #<?php echo $_GET['app_id']; ?></p>
            <p><strong>Consultation Fee:</strong> LKR.500.00</p>
        </div>
        
        <form action="pay_handler.php" method="POST">
            <input type="hidden" name="appointment_id" value="<?php echo $_GET['app_id']; ?>">
            
            <div class="input-group">
                <label>Card Number</label>
                <input type="text" placeholder="1234 5678 9101 1121" disabled>
                <small>(Demo Mode: No real card needed)</small>
            </div>
            
            <button type="submit" name="process_payment">Confirm & Pay</button>
        </form>
    </section>
</main>