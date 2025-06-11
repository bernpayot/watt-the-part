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
    alert($result['message']);
    
    if ($result['success']) {
        header("Location: list.php");
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
    alert($result['message']);
    
    if ($result['success']) {
        header("Location:index.php");
        exit();
    }
  }

  function alert($msg) {
      echo "<script type='text/javascript'>alert('$msg');</script>";
  }
?>

<div class="modal-overlay" style="display: none;">
  <div class="modal-container">
    <button id="close-checkout-modal" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">✖</button>
    <p class="header-text">Proceed to Checkout?</p>
    <p class="description-text">
      You're about to review your build and choose a<br>payment method.<br>
    </p>
    <a href="index.html"><button class="continue-button">Continue</button></a>
    <button class="continue-button" style="background: #ccc;">Cancel</button>
  </div>
</div>

<script>
  // Close checkout modal when clicking the close button
  const closeCheckoutModal = document.getElementById('close-checkout-modal');
  if (closeCheckoutModal) {
    closeCheckoutModal.addEventListener('click', function() {
      document.querySelector('.modal-overlay').style.display = 'none';
    });
  }
</script>