// Test if JavaScript is loading
console.log('JavaScript file loaded!');

let loginModal = document.querySelector('.login');
let loginModalContainer = document.querySelector('.login-modal');
let closeLoginModal = document.getElementById('close-login-modal');

let signUpModal = document.querySelector('.signup');
let signUpModalContainer = document.querySelector('.signup-modal');
let closeSignupModal = document.getElementById('close-signup-modal');
let signUpSpan = document.querySelector('.sign-up');
let loginText = document.querySelector('.logintext');

loginModal.onclick = function(){
  loginModalContainer.style.display = 'flex';
  signUpModalContainer.style.display = 'none';
}

closeLoginModal.onclick = function(){
  loginModalContainer.style.display = 'none';
}

closeSignupModal.onclick = function(){
  signUpModalContainer.style.display = 'none';
}

signUpModal.onclick = function(){
  signUpModalContainer.style.display = 'flex';
  loginModalContainer.style.display = 'none';
}

// Add click handlers for the text links
if (signUpSpan) {
  signUpSpan.onclick = function() {
    signUpModalContainer.style.display = 'flex';
    loginModalContainer.style.display = 'none';
  }
}

if (loginText) {
  loginText.onclick = function() {
    loginModalContainer.style.display = 'flex';
    signUpModalContainer.style.display = 'none';
  }
}

// Mobile Navigation Toggle
const hamburgerMenu = document.querySelector('.hamburger-menu');
const desktopHamburger = document.querySelector('.desktop-hamburger');
const mobileNav = document.querySelector('.mobile-nav');

// Function to toggle mobile nav
function toggleMobileNav() {
  mobileNav.classList.toggle('active');
}

// Add click event listeners to both hamburger buttons
hamburgerMenu.addEventListener('click', toggleMobileNav);
desktopHamburger.addEventListener('click', toggleMobileNav);

// Close mobile nav when clicking outside
document.addEventListener('click', function(event) {
  if (!hamburgerMenu.contains(event.target) && 
      !desktopHamburger.contains(event.target) && 
      !mobileNav.contains(event.target)) {
    mobileNav.classList.remove('active');
  }
});

// Checkout Modal
const checkoutButton = document.getElementById('check-out');
const checkoutModal = document.querySelector('.modal-overlay');

if (checkoutButton) {
  checkoutButton.addEventListener('click', function() {
    checkoutModal.style.display = 'flex';
  });
}

// Close checkout modal when clicking outside
document.addEventListener('click', function(event) {
  if (event.target === checkoutModal) {
    checkoutModal.style.display = 'none';
  }
});

// Function to remove a component from the build
function removeComponent(type) {
  // Send AJAX request to remove component
  fetch('remove_component.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'type=' + type
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Hide the component details
      document.getElementById(type + '-details').style.display = 'none';
      // Update total price
      updateTotalPrice();
    }
  })
  .catch(error => console.error('Error:', error));
}

// Function to update total price
function updateTotalPrice() {
  fetch('get_total_price.php')
    .then(response => response.json())
    .then(data => {
      document.getElementById('total-price').textContent = '₱' + data.total.toFixed(2);
    })
    .catch(error => console.error('Error:', error));
}

// Function to clear all components
function clearAllComponents() {
  console.log('Clearing all components...');
  
  if (confirm('Are you sure you want to clear all components?')) {
    fetch('clear_all.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      }
    })
    .then(response => {
      console.log('Response received:', response);
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text().then(text => {
        try {
          return JSON.parse(text);
        } catch (e) {
          console.error('Error parsing JSON:', text);
          throw new Error('Invalid JSON response');
        }
      });
    })
    .then(data => {
      console.log('Data received:', data);
      if (data.success) {
        console.log('Clearing successful, reloading page...');
        // Hide all component details before reload
        const componentTypes = ['cpu', 'motherboard', 'ram', 'storage', 'psu', 'case'];
        componentTypes.forEach(type => {
          const detailsElement = document.getElementById(type + '-details');
          if (detailsElement) {
            detailsElement.style.display = 'none';
          }
        });
        window.location.reload();
      } else {
        throw new Error(data.message || 'Failed to clear components');
      }
    })
    .catch(error => {
      console.error('Error during clear:', error);
      alert('Failed to clear components. Please try again.');
    });
  }
}

// Add click handler for clear all button
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, looking for clear all button...');
  const clearAllButton = document.getElementById('clear-all-btn');
  console.log('Clear all button found:', clearAllButton);
  
  if (clearAllButton) {
    clearAllButton.addEventListener('click', function(e) {
      console.log('Clear all button clicked!');
      e.preventDefault();
      clearAllComponents();
    });
  } else {
    console.error('Clear all button not found!');
  }
});

