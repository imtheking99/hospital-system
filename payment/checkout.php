<link rel="stylesheet" href="pay_style.css">
<main class="container">
    <section class="booking-card">
        <h3>Secure Checkout</h3>
        <div class="payment-summary">
            <p><strong>Appointment ID:</strong> #<?php echo htmlspecialchars($_GET['app_id'] ?? 'N/A'); ?></p>
            <p><strong>Consultation Fee:</strong> LKR.500.00</p>
        </div>
        
        <form action="pay_handler.php" method="POST">
            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($_GET['app_id'] ?? ''); ?>">
            
            <div class="input-group">
                <label for="card_number">Card Number</label>
                <input type="text" 
                       id="card_number" 
                       name="card_number" 
                       placeholder="1234 5678 9101 1121" 
                       pattern="[0-9]{16}" 
                       title="Please enter a 16-digit card number"
                       required>
                <small>(Enter 16-digit number of you card)</small>
            </div>
            
            <button type="submit" name="process_payment">Confirm & Pay</button>
        </form>
    </section>
</main>