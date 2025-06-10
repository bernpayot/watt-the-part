<?php
  require 'dbconn.php';
  require 'functions/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Watt The Part? | <?php echo $PageTitle ?></title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="navbar">
    <div class="logo"><img src="images/logo pink no bg.png" alt="Logo" class="logo-img" />
    <span>WATT THE PART?</span></div>
    
    <div class="navbar-right">
      <nav class="desktop-nav">
        <ul class="nav-links">
          <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a></li>
          <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">About</a></li>
          <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'list.php' ? 'active' : ''; ?>" href="list.php">Parts</a></li>
          <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'build.php' ? 'active' : ''; ?>" href="build.php">Build</a></li>
        </ul>
      </nav>
      
      <div class="nav-btns">
        <?php if ($auth->isLoggedIn()): ?>
          <div class="welcome-container">
            <div class="welcome-message">Welcome, <?php echo htmlspecialchars($auth->getCurrentUser()['username']); ?>!</div>
            <div class="desktop-menu">
              <button class="desktop-hamburger">
                <img src="assets/menu.svg" alt="Menu" />
              </button>
              <?php if ($auth->isLoggedIn()): ?>              
                <div class="desktop-dropdown">
                  <form action="logout.php" method="post">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                  </form>
                </div>                  
              <?php endif; ?>
            </div>
          </div>
        <?php else: ?>
          <button class="login">Log In</button>
          <button class="signup">Sign Up</button>
        <?php endif; ?>
      </div>

      <button class="hamburger-menu">
        <img src="assets/menu.svg" alt="Menu" />
      </button>
    </div>
  </header>

  <div class="mobile-nav">
    <nav>
      <ul class="mobile-nav-links">
        <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a></li>
        <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">About</a></li>
        <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'list.php' ? 'active' : ''; ?>" href="list.php">Parts</a></li>
        <li><a class="<?php echo basename($_SERVER['PHP_SELF']) == 'build.php' ? 'active' : ''; ?>" href="build.php">Build</a></li>
        <?php if ($auth->isLoggedIn()): ?>
          <li>
            <form action="logout.php" method="post">
              <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <div class="modal-container login-modal">
    <div class="modal-content">
      <button id="close-modal">✖</button>
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
        header("Location:list.php");
        exit();
    }
  }  
?>
  <div class="modal-container signup-modal">
    <div class="modal-content">    
      <button id="close-modal">✖</button>
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
        <button class="signup-button" type="submit" name="signup-btn">Sign Up</button></a>
      </form>
      <p class="or-text">or</p>
      <button class="google-sign"><img class="google-icon" src="assets/Google_Icons-09-512.webp"><span class="google-sign-text">Sign Up with Google</span></button>
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
  