<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PC Parts Catalog</title>
  <link rel="stylesheet" href="parts.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Nunito:wght@400;600;700&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <section class="hero">
    <div class="hero-text">
      <h1>Find the Perfect Part for Your Dream PC</h1>
      <p>
        Browse through our curated collection of PC components. From powerful CPUs to high-speed memory, explore parts that fit your build and budget. Click any item to view specs and add it to your custom setup.
      </p>
    </div>
  </section>

  <div class="container">
    <section class="filters">
    <div class="filter-dropdowns">
      <select>
        <option>Lowest to Highest</option>
        <option>Highest to Lowest</option>
      </select>

      <select>
        <option>All Categories</option>
        <option>Motherboard</option>
        <option>RAM</option>
        <option>CPU</option>
        <option>GPU</option>
        <option>Storage</option>
        <option>PSU</option>
        <option>PC Case</option>
      </select>
    </div>

    <div class="search-box">
      <input type="text" placeholder="Search Product Name" />
      <button><span>🔍</span></button>
    </div>
  </section>

  <section class="products-grid">
    <!-- columns dynamical -->
    <div class="column">
      <!-- Product card template -->
      <div class="product-card" data-id="PRODUCT_ID">
        <div class="product-image placeholder"></div>
        <div class="product-details">
          <h3>Product Name</h3>
          <ul>
            <li>Spec 1</li>
            <li>Spec 2</li>
            <li>Spec 3</li>
          </ul>
          <p class="price">₱0</p>
        </div>
      </div>
  </section>  
  </div>
  
  <div class="popup-overlay" id="popup">
    <div class="popup-card">
      <span class="close-btn" onclick="closePopup()">×</span>
      <div class="popup-image" id="popup-image"></div>
      <div class="popup-info">
        <h3 id="popup-title">Item Name</h3>
        <ul id="popup-specs">
          <li>Spec 1</li>
          <li>Spec 2</li>
          <li>Spec 3</li>
        </ul>
        <div class="popup-bottom">
          <p class="popup-price" id="popup-price">₱0</p>
          <button class="add-btn">Add to Build</button>
        </div>
      </div>
    </div>
  </div>

  <script src="parts.js"></script>
</body>
</html>
