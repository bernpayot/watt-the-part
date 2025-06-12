<div class="modal-container login-modal" style="display: none;">
    <div class="modal-content">
        <button id="close-login-modal">✖</button>
        <p class="login-text">Login</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p class="email-text">Email Address</p>
            <input class="email-input" type="text" name="email" placeholder="Enter your email address" required>
            <p class="password-text">Password</p>
            <input class="password-input" type="password" name="password" placeholder="Enter your password" required>
            <a href="forgotpassword.html"><p class="forgot-text">Forgot your password?</p></a>
            <button class="login-button" type="submit" name="login-btn">Log In</button>
        </form>
        <p class="or-text">or</p>
        <button class="google-sign">
            <img class="google-icon" src="assets/Google_Icons-09-512.webp" alt="Google Icon" />
            <span class="google-sign-text">Sign Up with Google</span>
        </button>
        <p class="no-account">Don't have an account? <span class="sign-up">Sign up</span></p>
    </div>
</div>

<?php
  if (isset($_POST["login-btn"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $result = $auth->login($email, $password);
    echo "<script>alert('" . addslashes($result['message']) . "');</script>";
    
    if ($result['success']) {
        header("Location: build.php");
        exit();
    }
  }  
?>

<div class="modal-container signup-modal" style="display: none;">
    <div class="modal-content">    
        <button id="close-signup-modal">✖</button>
        <p class="create-account-text">Create Account</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p class="full-name-text">Username</p>
            <input class="name-input" type="text" name="username" placeholder="Enter your username" minlength="3" maxlength="20" required>
            <p class="email-text">Email Address</p>
            <input class="email-input" type="text" name="email" placeholder="Enter your email address" required>
            <p class="password-text">Password</p>
            <input class="password-input" type="password" name="password" placeholder="Enter your password" required>
            <div class="terms-container">
                <input class="terms-checkbox" type="checkbox">
                <p class="terms-and-condition">I agree with <span class="terms">Terms</span> and <span class="privacy">Privacy</span></p>
            </div>
            <button class="signup-button" type="submit" name="signup-btn">Sign Up</button>
        </form>
        <p class="or-text">or</p>
        <button class="google-sign">
            <img class="google-icon" src="assets/Google_Icons-09-512.webp">
            <span class="google-sign-text">Sign Up with Google</span>
        </button>
        <p class="have-account">Already have an account ?&nbsp; <span class="logintext"> Log In</span></p>
    </div>
</div>

<?php
  if (isset($_POST["signup-btn"])) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $result = $auth->register($username, $email, $password);
    echo "<script>alert('" . addslashes($result['message']) . "');</script>";
    
    if ($result['success']) {
        header("Location:index.php");
        exit();
    }
  }
?>

<div class="modal-container checkout-modal" style="display: none;">
  <div class="modal-content">
    <button id="close-checkout-modal" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">✖</button>
    <p class="header-text">Proceed to Checkout?</p>
    <p class="description-text">
      You're about to review your build and choose a<br>payment method.<br>
    </p>
    <div class="button-container">
      <button class="continue-button" onclick="window.location.href='checkout.php'">Continue</button>
      <button class="continue-button cancel" style="background: #ccc;">Cancel</button>
    </div>
  </div>
</div>

<div class="modal-container thank-you-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1001;">
  <div class="modal-content">
    <button id="close-thank-you-modal" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">✖</button>
    <p class="header-text">Thank You for Shopping!</p>
    <p class="description-text">
      Your order has been received and is being processed.<br>
      We'll send you an email confirmation shortly.<br>
      Thank you for choosing Watt The Part!
    </p>
    <div class="button-container">
      <button class="continue-button" onclick="clearBuildAndRedirect('index.php')">Return to Home</button>
    </div>
  </div>
</div>

<div class="modal-container error-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1001;">
  <div class="modal-content">
    <p class="header-text" style="color: #ff4444;">Error</p>
    <p class="description-text" id="error-message">
      An error has occurred.<br>
      Please try again later.
    </p>
    <div class="button-container">
      <button class="continue-button" onclick="closeErrorModal()">Close</button>
    </div>
  </div>
</div>

<script>
  // Close checkout modal when clicking the close button
  const closeCheckoutModal = document.getElementById('close-checkout-modal');
  if (closeCheckoutModal) {
    closeCheckoutModal.addEventListener('click', function() {
      const modal = document.querySelector('.checkout-modal');
      const overlay = document.querySelector('.modal-overlay');
      if (modal) modal.style.display = 'none';
      if (overlay) overlay.remove();
    });
  }

  // Close thank you modal when clicking the close button
  const closeThankYouModal = document.getElementById('close-thank-you-modal');
  if (closeThankYouModal) {
    closeThankYouModal.addEventListener('click', function() {
      clearBuildAndRedirect();
    });
  }

  // Close error modal when clicking the close button
  const closeErrorModalBtn = document.getElementById('close-error-modal');
  if (closeErrorModalBtn) {
    closeErrorModalBtn.addEventListener('click', function() {
      closeErrorModal();
    });
  }

  // Function to close error modal
  function closeErrorModal() {
    const modal = document.querySelector('.error-modal');
    const overlay = document.querySelector('.modal-overlay');
    if (modal) modal.style.display = 'none';
    if (overlay) overlay.remove();
  }

  // Function to show error modal
  function showErrorModal(message) {
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
    
    // Update error message if provided
    if (message) {
      document.getElementById('error-message').innerHTML = message;
    }
    
    // Show the error modal
    const modal = document.querySelector('.error-modal');
    modal.style.display = 'flex';
    
    // Add click event to overlay to close modal
    overlay.addEventListener('click', function() {
      closeErrorModal();
    });
  }

  // Function to clear build data and optionally redirect
  function clearBuildAndRedirect(redirectUrl = null) {
    // Clear the build data
    fetch('functions/builder.php?action=clear', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        'Pragma': 'no-cache',
        'Expires': '0'
      },
      credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Hide the modal and overlay
        const modal = document.querySelector('.thank-you-modal');
        const overlay = document.querySelector('.modal-overlay');
        if (modal) modal.style.display = 'none';
        if (overlay) overlay.remove();
        
        // Redirect if URL is provided
        if (redirectUrl) {
          window.location.href = redirectUrl;
        }
      } else {
        showErrorModal('Failed to clear build data: ' + data.message);
      }
    })
    .catch(error => {
      showErrorModal('An error occurred while clearing build data. Please try again.');
    });
  }
</script>