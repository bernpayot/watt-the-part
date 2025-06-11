<?php
  $PageTitle = "List";
  require 'header.php';

  // Get component type from URL
  $component_type = isset($_GET['type']) ? $_GET['type'] : null;

  // Modify query to filter by component type if specified
  $query = "SELECT c.*, cb.brand_name, ct.type_name 
            FROM components c 
            JOIN component_brand cb ON c.brand_id = cb.brand_id 
            JOIN component_type ct ON c.ctype_id = ct.ctype_id";
  
  if ($component_type) {
    $query .= " WHERE ct.type_name = '" . mysqli_real_escape_string($conn, $component_type) . "'";
  }
  
  $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Nunito:wght@400;600;700&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem 0;
    }

    .product-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      cursor: pointer;
      overflow: hidden;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .product-image {
      width: 100%;
      height: 200px;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .product-details {
      padding: 1.5rem;
    }

    .product-details h3 {
      margin: 0 0 1rem 0;
      font-size: 1.1rem;
      color: #333;
    }

    .product-details ul {
      list-style: none;
      padding: 0;
      margin: 0 0 1rem 0;
    }

    .product-details li {
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .price {
      font-size: 1.2rem;
      font-weight: 600;
      color: #2c5282;
      margin: 0;
    }

    @media (max-width: 768px) {
      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem 0;
      }
    }

    @media (max-width: 480px) {
      .products-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 1rem 0;
      }
    }
  </style>
</head>
<body>
  <section class="hero">
    <div class="hero-text">
      <h1>Select Your <?php echo ucfirst($component_type); ?></h1>
      <p>
        Browse through our curated collection of <?php echo $component_type; ?> components. 
        Click any item to view specs and add it to your build.
      </p>
    </div>
  </section>

  <div class="container">
    <section class="filters">
      <div class="filter-dropdowns">
        <select id="sort-price">
          <option value="asc">Lowest to Highest</option>
          <option value="desc">Highest to Lowest</option>
        </select>
      </div>

      <div class="search-box">
        <input type="text" id="search-input" placeholder="Search Product Name" />
        <button><span>🔍</span></button>
      </div>
    </section>

    <section class="products-grid">
      <?php
        if(mysqli_num_rows($result) > 0) {
          while($component = mysqli_fetch_assoc($result)) {
            $formatted_price = "₱" . number_format($component['price'], 2);
            
            echo "<div class='product-card' data-id='{$component['component_id']}' data-category='{$component['ctype_id']}'>";
            echo "<div class='product-image placeholder'></div>";
            echo "<div class='product-details'>";
            echo "<h3>{$component['name']}</h3>";
            echo "<ul>";
            echo "<li>Brand: {$component['brand_name']}</li>";
            echo "<li>Type: {$component['type_name']}</li>";
            echo "</ul>";
            echo "<p class='price'>{$formatted_price}</p>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p class='no-results'>No components found.</p>";
        }
      ?>
    </section>  
  </div>
  
  <div class="popup-overlay" id="popup">
    <div class="popup-card">
      <span class="close-btn" onclick="closePopup()">×</span>
      <div class="popup-image" id="popup-image"></div>
      <div class="popup-info">
        <h3 id="popup-title">Item Name</h3>
        <div class="popup-bottom">
          <p class="popup-price" id="popup-price">₱0</p>
          <button class="add-btn" onclick="selectComponent()">Add to Build</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let selectedComponent = null;

    // Add click event to product cards
    document.querySelectorAll('.product-card').forEach(card => {
      card.addEventListener('click', function() {
        const componentData = {
          id: this.dataset.id,
          name: this.querySelector('h3').textContent,
          brand: this.querySelector('li').textContent.replace('Brand: ', ''),
          specs: this.querySelectorAll('li')[1].textContent.replace('Type: ', ''),
          price: parseFloat(this.querySelector('.price').textContent.replace('₱', '').replace(',', '')),
          type: '<?php echo $component_type; ?>'
        };
        
        showPopup(componentData);
      });
    });

    function showPopup(component) {
      selectedComponent = component;
      document.getElementById('popup-title').textContent = component.name;
      document.getElementById('popup-price').textContent = '₱' + component.price.toLocaleString();
      document.getElementById('popup').style.display = 'flex';
    }

    function closePopup() {
      document.getElementById('popup').style.display = 'none';
    }

    function selectComponent() {
      if (selectedComponent) {
        // Send component data via AJAX
        fetch('functions/builder.php?action=add', {  // Updated path
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(selectedComponent)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Close the popup
            closePopup();
            // Redirect to build page
            window.location.href = 'build.php';
          } else {
            alert('Failed to add component: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to add component. Please try again.');
        });
      }
    }

    // Add event listeners for filtering and sorting
    document.getElementById('sort-price').addEventListener('change', function() {
      const cards = Array.from(document.querySelectorAll('.product-card'));
      const container = document.querySelector('.products-grid');
      const direction = this.value;
      
      cards.sort((a, b) => {
        const priceA = parseFloat(a.querySelector('.price').textContent.replace('₱', '').replace(',', ''));
        const priceB = parseFloat(b.querySelector('.price').textContent.replace('₱', '').replace(',', ''));
        return direction === 'asc' ? priceA - priceB : priceB - priceA;
      });
      
      cards.forEach(card => container.appendChild(card));
    });

    document.getElementById('search-input').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const cards = document.querySelectorAll('.product-card');
      
      cards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        if (title.includes(searchTerm)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>

<?php
  require 'footer.php';
  mysqli_close($conn);
?>