<?php
    $PageTitle = "Checkout";
    require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <input type="radio" class="payment-radio">
                    <h1>GCash</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" class="payment-radio">
                    <h1>PayMaya</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" class="payment-radio">
                    <h1>PayPal</h1>
                </div>  
                
                <p>Debit Card</p>
                <div class="online-payment">
                    <input type="radio" class="payment-radio">
                    <h1>MasterCard</h1>
                </div>
                <div class="online-payment">
                    <input type="radio" class="payment-radio">
                    <h1>Visa</h1>
                </div>                                  
            </div>
        </section>
        
        <section class="item-info">
            <div class="item-full-price">
                <h1>
                    Item
                </h1>
                <p>
                    subtotal price container
                </p>
            </div>
            <p>Payment Details</p>
            <hr>
            <div class="payment-detail">
                <div class="detail">
                    <p>Item 1</p>
                    <p>price</p>
                </div>
                <div class="detail">
                    <p>Item 2</p>
                    <p>price</p>
                </div>                
            </div>

            <hr>
            <div class="total-price">
                <p>Total</p>
                <p>total price</p>
                
            </div>

            <div class="pay-btn">
                <a href="#" class="pay-btn-gradient">Pay Now</a>                
            </div>
        </section>
    </main>
</body>
</html>

<?php
    require 'footer.php';
?>