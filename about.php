<?php
    $PageTitle = "About";
    include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <section class="intro">
        <div class="intro-text">
          <p>
            <strong>At WATT THE PART</strong>, we believe building your <span class="highlight">dream PC</span> should be exciting, not overwhelming.
            Whether you're a first-time builder or a seasoned enthusiast, our platform helps you plan your setup, discover compatible parts, and get buying links from trusted stores — no guesswork, no pressure.
          </p>
        </div>
        <img src="assets/logo no bg .png" alt="Color Dots" class="dots-image" />
      </section>

      <section class="features">
        <div class="feature-card">
          <div class="icon"><i class="fas fa-lightbulb"></i></div>
          <h3>Smart Recommendations</h3>
          <p>Get part suggestions based on compatibility, category, and budget.</p>
        </div>
      
        <div class="feature-card">
          <div class="icon"><i class="fas fa-search"></i></div>
          <h3>Browse Trusted Parts</h3>
          <p>Explore a growing catalog of PC components curated from verified sellers.</p>
        </div>
      
        <div class="feature-card">
          <div class="icon"><i class="fas fa-cogs"></i></div>
          <h3>Simulate Your Build</h3>
          <p>Add, edit, and review your parts with a live price estimate — no checkout, just plan smart.</p>
        </div>
      </section>

      <section class="team-section">
        <h2>Meet The Team</h2>
        <div class="divider"></div>
        <p class="team-subtext">in the PC industry — so you can build with confidence.</p>
    
        <div class="team-grid">
          <div class="team-member"><span class="avatar"></span><p>Clarence Ferrer<br><small>Front End Developer</small></p></div>
          <div class="team-member"><span class="avatar"></span><p>Jonathan Ramasanta<br><small>Front End Developer</small></p></div>
          <div class="team-member"><span class="avatar"></span><p>Johann Gumiran<br><small>Front End Developer</small></p></div>
          <div class="team-member"><span class="avatar"></span><p>Brenda Baroma<br><small>UI/UX Designer</small></p></div>
          <div class="team-member"><span class="avatar"></span><p>Bem Payot<br><small>Back End Developer</small></p></div>
        </div>
      </section>
</body>
</html>
<?php
  include 'footer.php';
?>