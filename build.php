<?php
  $PageTitle = "Build";
  require 'header.php';
  require_once 'functions/builder.php';

  // Calculate total price
  $total = 0;
  $build_data = getBuildData();
  foreach ($build_data as $component) {
    $total += $component['price'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PC Building</title>
  <link rel="stylesheet" href="style.css" />
  <script defer src="build.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <!-- ⬇ hero -->
  <section class="head">
    <h1>Customize Your Dream<br />PC, One Part at a Time</h1>
    <p>
      Start building your perfect rig by adding components to each category.
      Pick from our recommended parts, see their details, and track your total
      estimated cost. No purchases—just smart planning. When you're done, you
      can copy your setup or share it!
    </p>
  </section>

  <!-- ⬇ builder -->
  <section class="middle">
    <div class="build-wrapper">
      <div class="build-div">
        <div id="build-header">
          <ul>
            <li>Components</li><li>Products</li><li>Details</li><li>Price</li>
            <li><button id="clear-all-btn">Clear All</button></li>
          </ul>
        </div>

        <!-- ==== CPU row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=cpu"><button class="add-button"><span class="add-text">+</span></button></a>
            <p class="components-name">CPU</p>
            <div class="component-details" id="cpu-details" <?php echo (isset($build_data['cpu'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['cpu']) ? $build_data['cpu']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['cpu']) ? '₱' . number_format($build_data['cpu']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- ==== Motherboard row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=motherboard"><button class="add-button"><span class="add-text">+</span></button></a>
            <p>Motherboard</p>
            <div class="component-details" id="motherboard-details" <?php echo (isset($build_data['motherboard'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['motherboard']) ? $build_data['motherboard']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['motherboard']) ? '₱' . number_format($build_data['motherboard']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- ==== RAM row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=ram"><button class="add-button"><span class="add-text">+</span></button></a>
            <p>RAM</p>
            <div class="component-details" id="ram-details" <?php echo (isset($build_data['ram'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['ram']) ? $build_data['ram']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['ram']) ? '₱' . number_format($build_data['ram']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- ==== Storage row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=storage"><button class="add-button"><span class="add-text">+</span></button></a>
            <p>Storage</p>
            <div class="component-details" id="storage-details" <?php echo (isset($build_data['storage'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['storage']) ? $build_data['storage']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['storage']) ? '₱' . number_format($build_data['storage']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- ==== Power Supply row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=psu"><button class="add-button"><span class="add-text">+</span></button></a>
            <p>Power Supply</p>
            <div class="component-details" id="psu-details" <?php echo (isset($build_data['psu'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['psu']) ? $build_data['psu']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['psu']) ? '₱' . number_format($build_data['psu']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- ==== Case row ==== -->
        <div class="component-container">
          <div class="components">
            <a href="list.php?type=case"><button class="add-button"><span class="add-text">+</span></button></a>
            <p>Case</p>
            <div class="component-details" id="case-details" <?php echo (isset($build_data['case'])) ? 'style="display: flex;"' : ''; ?>>
              <div class="product-image"></div>
              <div class="product-info">
                <ul>
                  <li id="no-decoration"><?php echo isset($build_data['case']) ? $build_data['case']['name'] : 'Product Name'; ?></li>
                </ul>
                <p class="price"><?php echo isset($build_data['case']) ? '₱' . number_format($build_data['case']['price'], 2) : '₱8,500.00'; ?></p>
              </div>
              <div class="action-icons">
                <i class="fas fa-trash-alt delete-icon"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="build-footer">
          <p style="color: var(--bg-dark);">SUBTOTAL</p>
          <p style="color: var(--bg-dark);"><?php echo '₱' . number_format($total, 2); ?></p>
        </div>
      </div>

      <!-- right pane -->
      <div class="right-container">
        <div class="subtotal-container">
          <div class="text-container">
            <h1>SUBTOTAL</h1>
          </div>
          <p id="total-price"><?php echo '₱' . number_format($total, 2); ?></p>
        </div>
        <button id="check-out" onclick="event.preventDefault(); event.stopPropagation(); handleCheckout();">Check Out</button>
      </div>
    </div>
  </section>

  <!-- recommended section … -->
  <section class="recommended">
    <div class="gradient-divider"></div>
    <h1>Recommended Builds For You</h1>
    <p>Explore battle-tested builds curated by our experts. Choose one, customize it, or build it as-is for<br>maximum performance and peace of mind.</p>
    <div class="recommended-builds">
      <div><img src="images/Parts/ak400.png" alt=""></div>
      <div><img src="images/Parts/gigabyte_4060ti.png" alt=""></div>
    </div>
  </section>

  <!-- Build-specific error modal -->
  <div class="modal-container build-error-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1001;">
    <div class="modal-content">
      <button id="close-build-error-modal" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">✖</button>
      <p class="header-text" style="color: #ff4444;">Error</p>
      <p class="description-text" id="build-error-message">
        Please add at least one component to your build before checking out.
      </p>
      <div class="button-container">
        <button class="continue-button" onclick="closeBuildErrorModal()">Close</button>
      </div>
    </div>
  </div>

  <script>
    // Override the original showErrorModal function to prevent it from being used
    window.showErrorModal = function(message) {
      // Remove any existing modals first
      const existingOverlay = document.querySelector('.modal-overlay');
      if (existingOverlay) existingOverlay.remove();
      
      const existingCheckoutModal = document.querySelector('.checkout-modal');
      if (existingCheckoutModal) existingCheckoutModal.style.display = 'none';

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
      const errorModal = document.querySelector('.build-error-modal');
      const errorMessage = document.getElementById('build-error-message');
      if (message) errorMessage.innerHTML = message;
      errorModal.style.display = 'flex';
      errorModal.style.zIndex = '1001';

      // Add click event to overlay to close modal
      overlay.addEventListener('click', function() {
        closeBuildErrorModal();
      });

      // Add click event to close button
      const closeButton = document.getElementById('close-build-error-modal');
      if (closeButton) {
        closeButton.onclick = function() {
          closeBuildErrorModal();
        };
      }
    };

    function handleCheckout() {
      // Check for visible component details
      const visibleComponents = document.querySelectorAll('.component-details[style*="display: flex"]');
      
      if (visibleComponents.length === 0) {
        showErrorModal('Please add at least one component to your build before checking out.');
        return; // Stop here if no components
      }
      
      // Only show checkout modal if we have components
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
      
      const modal = document.querySelector('.checkout-modal');
      modal.style.display = 'flex';
      modal.style.zIndex = '1001';
      
      // Add click event to overlay to close modal
      overlay.addEventListener('click', function() {
        modal.style.display = 'none';
        overlay.remove();
      });

      // Add click event to cancel button
      const cancelButton = modal.querySelector('.cancel');
      if (cancelButton) {
        cancelButton.onclick = function() {
          modal.style.display = 'none';
          overlay.remove();
        };
      }

      // Add click event to close button
      const closeButton = modal.querySelector('#close-checkout-modal');
      if (closeButton) {
        closeButton.onclick = function() {
          modal.style.display = 'none';
          overlay.remove();
        };
      }
    }

    function closeBuildErrorModal() {
      const modal = document.querySelector('.build-error-modal');
      const overlay = document.querySelector('.modal-overlay');
      if (modal) modal.style.display = 'none';
      if (overlay) overlay.remove();
    }
  </script>
</body>
</html>

<?php
  require 'footer.php';
?>
