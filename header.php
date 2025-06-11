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
            <a href="logout.php">Log out</a>
          </li>
        <?php else: ?>
          <li>
            <button class="login">Log In</button>
          </li>
          <li>
            <button class="signup">Sign Up</button>
          </li>  
        <?php endif; ?>
      </ul>
    </nav>
  </div>

<?php include 'components/modals.php'; ?>
