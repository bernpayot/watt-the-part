<?php
    $PageTitle = "Checkout";
    require 'header.php';
    require_once 'functions/builder.php';

    // Get build data and calculate total
    $build_data = getBuildData();
    $total = 0;
    foreach ($build_data as $component) {
        $total += $component['price'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="payment-container">
        <section class="payment-method">
            <h1>
                Choose a Payment Method
            </h1>
            <p>Select your preferred payment option:</p>

            <div class="payment-method-container">
                <p>Online Wallet</p>
                <div class="online-payment">
                    <input type="radio" name="payment-method" class="payment-radio" value="gcash">
                    <h1>GCash</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" name="payment-method" class="payment-radio" value="paymaya">
                    <h1>PayMaya</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" name="payment-method" class="payment-radio" value="paypal">
                    <h1>PayPal</h1>
                </div>  
                
                <p>Debit Card</p>
                <div class="online-payment">
                    <input type="radio" name="payment-method" class="payment-radio" value="mastercard">
                    <h1>MasterCard</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" name="payment-method" class="payment-radio" value="visa">
                    <h1>Visa</h1>
                </div>                                  
            </div>
        </section>
        
        <section class="item-info">
            <div class="item-full-price">
                <h1>
                    Your Build
                </h1>
                <p>
                    Total: ₱<?php echo number_format($total, 2); ?>
                </p>
            </div>
            <p>Payment Details</p>
            <hr>
            <div class="payment-detail">
                <?php foreach ($build_data as $type => $component): ?>
                <div class="detail">
                    <p><?php echo ucfirst($type) . ': ' . $component['name']; ?></p>
                    <p>₱<?php echo number_format($component['price'], 2); ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <hr>
            <div class="total-price">
                <p>Total</p>
                <p>₱<?php echo number_format($total, 2); ?></p>
            </div>

            <div class="pay-btn">
                <a href="#" class="pay-btn-gradient" onclick="handlePayment(); return false;">Pay Now</a>                
            </div>
        </section>
    </main>

    <script>
        function showErrorModal(message) {
            // Remove any existing modals first
            const existingOverlay = document.querySelector('.modal-overlay');
            if (existingOverlay) existingOverlay.remove();
            
            // Create new overlay
            const overlay = document.createElement('div');
            overlay.className = 'modal-overlay';
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            overlay.style.zIndex = '1000';
            document.body.appendChild(overlay);
            
            // Show error modal
            const errorModal = document.querySelector('.error-modal');
            const errorMessage = document.getElementById('error-message');
            if (message) errorMessage.innerHTML = message;
            errorModal.style.display = 'flex';
            errorModal.style.zIndex = '1001';
            
            // Add click event to overlay to close modal
            overlay.addEventListener('click', function() {
                closeErrorModal();
            });
        }

        function closeErrorModal() {
            const modal = document.querySelector('.error-modal');
            const overlay = document.querySelector('.modal-overlay');
            if (modal) modal.style.display = 'none';
            if (overlay) overlay.remove();
        }

        function handlePayment() {
            // Check if a payment method is selected
            const selectedPayment = document.querySelector('input[name="payment-method"]:checked');
            
            if (!selectedPayment) {
                showErrorModal('Please select a payment method before proceeding.');
                return;
            }
            
            // If payment method is selected, show thank you modal
            showThankYouModal();
        }

        function showThankYouModal() {
            // Show the modal overlay
            const overlay = document.createElement('div');
            overlay.className = 'modal-overlay';
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            overlay.style.zIndex = '1000';
            document.body.appendChild(overlay);
            
            // Show the thank you modal
            const modal = document.querySelector('.thank-you-modal');
            modal.style.display = 'flex';
            modal.style.zIndex = '1001';
            
            // Add click event to overlay to close modal
            overlay.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.remove();
            });
        }
    </script>
</body>
</html>

<?php
    require 'footer.php';
?>