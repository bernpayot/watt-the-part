// Build page specific JavaScript
console.log('Build page JavaScript loaded!');

// Function to update the UI with build data
function updateBuildUI(buildData, total) {
    // Update each component's display
    const componentTypes = ['cpu', 'motherboard', 'ram', 'storage', 'psu', 'case'];
    componentTypes.forEach(type => {
        const detailsElement = document.getElementById(type + '-details');
        if (detailsElement) {
            if (buildData[type]) {
                // Show and update component details
                detailsElement.style.display = 'flex';
                const nameElement = detailsElement.querySelector('#no-decoration');
                const priceElement = detailsElement.querySelector('.price');
                if (nameElement) nameElement.textContent = buildData[type].name;
                if (priceElement) priceElement.textContent = '₱' + buildData[type].price.toLocaleString();
            } else {
                // Hide component details
                detailsElement.style.display = 'none';
            }
        }
    });

    // Update total price
    const totalElements = document.querySelectorAll('.build-footer p:last-child, .subtotal-container #total-price');
    totalElements.forEach(element => {
        element.textContent = '₱' + total.toLocaleString();
    });
}

// Function to fetch and update build data
function fetchAndUpdateBuild() {
    fetch('builder/get_build_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBuildUI(data.data, data.total);
            }
        })
        .catch(error => console.error('Error fetching build data:', error));
}

// Function to remove a component
function removeComponent(componentType) {
    console.log('removeComponent called with type:', componentType);

    if (!confirm('Are you sure you want to remove this component?')) {
        return;
    }

    // Show loading state
    const detailsDiv = document.getElementById(`${componentType}-details`);
    if (detailsDiv) {
        detailsDiv.style.opacity = '0.5';
    }

    // Make AJAX call to remove component
    fetch('functions/builder.php?action=remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `component=${encodeURIComponent(componentType)}`
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Hide the component details
            if (detailsDiv) {
                detailsDiv.style.display = 'none';
            }

            // Update the total price
            const totalElements = document.querySelectorAll('.build-footer p:last-child, .subtotal-container #total-price');
            totalElements.forEach(element => {
                element.textContent = `₱${parseFloat(data.total).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`;
            });

            // Show success message
            alert('Component removed successfully');
        } else {
            // Show error message
            alert(data.message || 'Failed to remove component');
            
            // Reset loading state
            if (detailsDiv) {
                detailsDiv.style.opacity = '1';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing the component');
        
        // Reset loading state
        if (detailsDiv) {
            detailsDiv.style.opacity = '1';
        }
    });
}

// Function to clear all components
function clearAllComponents() {
    console.log('Clear all button clicked');
    if (confirm('Are you sure you want to clear all components?')) {
        console.log('User confirmed clear all');
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
        .then(response => {
            console.log('Response received:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            if (data.success) {
                // Update the UI with empty data
                updateBuildUI({}, 0);
            } else {
                throw new Error(data.message || 'Failed to clear components');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to clear components. Please try again.');
        });
    }
}

// Function to show checkout modal
function showCheckoutModal() {
    const modal = document.querySelector('.checkout-modal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Function to hide checkout modal
function hideCheckoutModal() {
    const modal = document.querySelector('.checkout-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Add event listeners when the document is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    // Add click handlers for all delete icons
    const deleteIcons = document.querySelectorAll('.delete-icon');
    console.log('Found delete icons:', deleteIcons.length);
    
    deleteIcons.forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            const componentType = this.closest('.component-details').id.replace('-details', '');
            console.log('Delete icon clicked for:', componentType);
            removeComponent(componentType);
        });
    });

    // Add click handler for clear all button
    const clearAllButton = document.getElementById('clear-all-btn');
    if (clearAllButton) {
        clearAllButton.addEventListener('click', function(e) {
            e.preventDefault();
            clearAllComponents();
        });
    }

    // Add click handlers for checkout modal
    const closeCheckoutModal = document.getElementById('close-checkout-modal');
    const cancelCheckout = document.querySelector('.checkout-modal .cancel');
    const continueCheckout = document.querySelector('.checkout-modal .continue-button:first-child');

    if (closeCheckoutModal) {
        closeCheckoutModal.addEventListener('click', function() {
            hideCheckoutModal();
        });
    }

    if (cancelCheckout) {
        console.log('Cancel button found:', cancelCheckout); // Debug log
        cancelCheckout.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent any default behavior
            console.log('Cancel button clicked'); // Debug log
            hideCheckoutModal();
        });
    }

    if (continueCheckout) {
        continueCheckout.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'checkout.php';
        });
    }
}); 