<?php
    $PageTitle = "Admin Dashboard";
    require_once '../dbconn.php';
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    // Get user data and check role
    $user_id = $_SESSION['user_id'];
    $query = "SELECT role_id FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Redirect if not admin (role_id != 1)
    if (!$user || $user['role_id'] != 1) {
        header("Location: ../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watt the Part? | <?php echo $PageTitle; ?></title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar Navigation -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
            </div>
            <ul class="nav-links">
                <li class="active">
                    <a href="#dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#users"><i class="bi bi-people"></i> Users</a>
                </li>
                <li>
                    <a href="#components"><i class="bi bi-cpu"></i> Components</a>
                </li>
                <li>
                    <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="top-bar">
                <div class="toggle-sidebar">
                    <i class="bi bi-list"></i>
                </div>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                </div>
            </header>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserForm">
                                <input type="hidden" id="edit_user_id" name="user_id">
                                <div class="mb-3">
                                    <label for="edit_username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="edit_username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select class="form-select" id="edit_role" name="role_id" required>
                                        <option value="1">Admin</option>
                                        <option value="2">User</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveUserChanges">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this user? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Component Modal -->
            <div class="modal fade" id="editComponentModal" tabindex="-1" aria-labelledby="editComponentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editComponentModalLabel">Edit Component</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editComponentForm">
                                <input type="hidden" id="edit_component_id" name="component_id">
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="edit_price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_brand" class="form-label">Brand</label>
                                    <select class="form-select" id="edit_brand" name="brand_id" required>
                                        <?php
                                            $query = "SELECT brand_id, brand_name FROM component_brand ORDER BY brand_name";
                                            $result = mysqli_query($conn, $query);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['brand_id'] . "'>" . htmlspecialchars($row['brand_name']) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_type" class="form-label">Type</label>
                                    <select class="form-select" id="edit_type" name="ctype_id" required>
                                        <?php
                                            $query = "SELECT ctype_id, type_name FROM component_type ORDER BY type_name";
                                            $result = mysqli_query($conn, $query);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['ctype_id'] . "'>" . htmlspecialchars($row['type_name']) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveComponentChanges">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Component Confirmation Modal -->
            <div class="modal fade" id="deleteComponentModal" tabindex="-1" aria-labelledby="deleteComponentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteComponentModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this component? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmComponentDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Component Modal -->
            <div class="modal fade" id="addComponentModal" tabindex="-1" aria-labelledby="addComponentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addComponentModalLabel">Add New Component</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addComponentForm">
                                <div class="mb-3">
                                    <label for="new_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="new_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="new_price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_brand" class="form-label">Brand</label>
                                    <select class="form-select" id="new_brand" name="brand_id" required>
                                        <?php
                                            $query = "SELECT brand_id, brand_name FROM component_brand ORDER BY brand_name";
                                            $result = mysqli_query($conn, $query);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['brand_id'] . "'>" . htmlspecialchars($row['brand_name']) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="new_type" class="form-label">Type</label>
                                    <select class="form-select" id="new_type" name="ctype_id" required>
                                        <?php
                                            $query = "SELECT ctype_id, type_name FROM component_type ORDER BY type_name";
                                            $result = mysqli_query($conn, $query);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['ctype_id'] . "'>" . htmlspecialchars($row['type_name']) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveNewComponent">Add Component</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="content-area">
                <div id="dashboard" class="section active">
                    <h2>Dashboard Overview</h2>
                    <div class="stats-container">
                        <div class="stat-card">
                            <i class="bi bi-people"></i>
                            <div class="stat-info">
                                <?php
                                    $query = "SELECT COUNT(*) as total FROM users WHERE role_id = 2";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<h3>" . $row['total'] . "</h3>";
                                ?>
                                <p>Total Users</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="bi bi-cpu"></i>
                            <div class="stat-info">
                                <?php
                                    $query = "SELECT COUNT(*) as total FROM components";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<h3>" . $row['total'] . "</h3>";
                                ?>
                                <p>Total Components</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <div id="users" class="section">
                    <h2>User Management</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT u.*, r.name as role_name FROM users u 
                                             JOIN roles r ON u.role_id = r.role_id 
                                             ORDER BY u.user_id DESC";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['user_id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['role_name'] . "</td>";
                                        echo "<td>" . date('M d, Y', strtotime($row['registered_at'])) . "</td>";
                                        echo "<td>
                                                <button class='btn btn-sm btn-primary edit-user' 
                                                        data-user-id='" . $row['user_id'] . "'
                                                        data-username='" . htmlspecialchars($row['username']) . "'
                                                        data-email='" . htmlspecialchars($row['email']) . "'
                                                        data-role='" . $row['role_id'] . "'>
                                                    <i class='bi bi-pencil'></i>
                                                </button>
                                                <button class='btn btn-sm btn-danger delete-user' 
                                                        data-user-id='" . $row['user_id'] . "'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Components Section -->
                <div id="components" class="section">
                    <h2>Component Management</h2>
                    <div class="table-responsive">
                        <div class="mb-3">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addComponentModal">
                                <i class="bi bi-plus-circle"></i> Add New Component
                            </button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT c.*, cb.brand_name, ct.type_name 
                                             FROM components c 
                                             JOIN component_brand cb ON c.brand_id = cb.brand_id 
                                             JOIN component_type ct ON c.ctype_id = ct.ctype_id 
                                             ORDER BY c.component_id DESC";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['component_id'] . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['type_name']) . "</td>";
                                        echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>
                                                <button class='btn btn-sm btn-primary edit-component' 
                                                        data-component-id='" . $row['component_id'] . "'
                                                        data-name='" . htmlspecialchars($row['name']) . "'
                                                        data-price='" . $row['price'] . "'
                                                        data-brand='" . $row['brand_id'] . "'
                                                        data-type='" . $row['ctype_id'] . "'>
                                                    <i class='bi bi-pencil'></i>
                                                </button>
                                                <button class='btn btn-sm btn-danger delete-component' 
                                                        data-component-id='" . $row['component_id'] . "'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Bootstrap modals
        const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        const deleteUserModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
        const editComponentModal = new bootstrap.Modal(document.getElementById('editComponentModal'));
        const deleteComponentModal = new bootstrap.Modal(document.getElementById('deleteComponentModal'));
        const addComponentModal = new bootstrap.Modal(document.getElementById('addComponentModal'));
        let currentUserId = null;
        let currentComponentId = null;

        // Function to initialize component event listeners
        function initializeComponentButtons(row) {
            // Edit button
            const editButton = row.querySelector('.edit-component');
            if (editButton) {
                editButton.addEventListener('click', function() {
                    const componentId = this.dataset.componentId;
                    const name = this.dataset.name;
                    const price = this.dataset.price;
                    const brand = this.dataset.brand;
                    const type = this.dataset.type;

                    document.getElementById('edit_component_id').value = componentId;
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_price').value = price;
                    document.getElementById('edit_brand').value = brand;
                    document.getElementById('edit_type').value = type;

                    editComponentModal.show();
                });
            }

            // Delete button
            const deleteButton = row.querySelector('.delete-component');
            if (deleteButton) {
                deleteButton.addEventListener('click', function() {
                    currentComponentId = this.dataset.componentId;
                    deleteComponentModal.show();
                });
            }
        }

        // Initialize event listeners for existing components
        document.querySelectorAll('#components table tbody tr').forEach(row => {
            initializeComponentButtons(row);
        });

        // Edit user functionality
        document.querySelectorAll('.edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const username = this.dataset.username;
                const email = this.dataset.email;
                const role = this.dataset.role;

                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_role').value = role;

                editUserModal.show();
            });
        });

        // Save user changes
        document.getElementById('saveUserChanges').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('editUserForm'));
            formData.append('action', 'update');

            fetch('functions/user_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });

        // Delete user functionality
        document.querySelectorAll('.delete-user').forEach(button => {
            button.addEventListener('click', function() {
                currentUserId = this.dataset.userId;
                deleteUserModal.show();
            });
        });

        // Confirm delete
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (!currentUserId) return;

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('user_id', currentUserId);

            fetch('functions/user_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });

        // Toggle sidebar
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.admin-container').classList.toggle('sidebar-collapsed');
        });

        // Navigation
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    
                    // Update active states
                    document.querySelectorAll('.nav-links li').forEach(li => li.classList.remove('active'));
                    this.parentElement.classList.add('active');
                    
                    // Show target section
                    document.querySelectorAll('.section').forEach(section => {
                        section.classList.remove('active');
                    });
                    document.getElementById(targetId).classList.add('active');
                }
            });
        });

        // Save component changes
        document.getElementById('saveComponentChanges').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('editComponentForm'));
            formData.append('action', 'update');

            fetch('functions/component_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal
                    editComponentModal.hide();
                    
                    // Update the table row
                    const row = document.querySelector(`button[data-component-id="${formData.get('component_id')}"]`).closest('tr');
                    const cells = row.cells;
                    
                    // Update the row data
                    cells[1].textContent = formData.get('name');
                    cells[2].textContent = document.querySelector(`#edit_brand option[value="${formData.get('brand_id')}"]`).textContent;
                    cells[3].textContent = document.querySelector(`#edit_type option[value="${formData.get('ctype_id')}"]`).textContent;
                    cells[4].textContent = '$' + parseFloat(formData.get('price')).toFixed(2);
                    
                    // Update the data attributes on the edit button
                    const editButton = row.querySelector('.edit-component');
                    editButton.dataset.name = formData.get('name');
                    editButton.dataset.price = formData.get('price');
                    editButton.dataset.brand = formData.get('brand_id');
                    editButton.dataset.type = formData.get('ctype_id');
                    
                    // Show success message
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });

        // Confirm component delete
        document.getElementById('confirmComponentDelete').addEventListener('click', function() {
            if (!currentComponentId) return;

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('component_id', currentComponentId);

            fetch('functions/component_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal
                    deleteComponentModal.hide();
                    
                    // Remove the row from the table
                    const row = document.querySelector(`button[data-component-id="${currentComponentId}"]`).closest('tr');
                    row.remove();
                    
                    // Show success message
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });

        // Add new component functionality
        document.getElementById('saveNewComponent').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('addComponentForm'));
            formData.append('action', 'create');

            fetch('functions/component_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal
                    addComponentModal.hide();
                    
                    // Add new row to the table
                    const tbody = document.querySelector('#components table tbody');
                    const newRow = document.createElement('tr');
                    
                    // Get the brand and type names from the select options
                    const brandName = document.querySelector(`#new_brand option[value="${formData.get('brand_id')}"]`).textContent;
                    const typeName = document.querySelector(`#new_type option[value="${formData.get('ctype_id')}"]`).textContent;
                    
                    newRow.innerHTML = `
                        <td>${data.component_id}</td>
                        <td>${formData.get('name')}</td>
                        <td>${brandName}</td>
                        <td>${typeName}</td>
                        <td>$${parseFloat(formData.get('price')).toFixed(2)}</td>
                        <td>
                            <button class='btn btn-sm btn-primary edit-component' 
                                    data-component-id='${data.component_id}'
                                    data-name='${formData.get('name')}'
                                    data-price='${formData.get('price')}'
                                    data-brand='${formData.get('brand_id')}'
                                    data-type='${formData.get('ctype_id')}'>
                                <i class='bi bi-pencil'></i>
                            </button>
                            <button class='btn btn-sm btn-danger delete-component' 
                                    data-component-id='${data.component_id}'>
                                <i class='bi bi-trash'></i>
                            </button>
                        </td>
                    `;
                    
                    // Add the new row at the top of the table
                    tbody.insertBefore(newRow, tbody.firstChild);
                    
                    // Initialize event listeners for the new row
                    initializeComponentButtons(newRow);
                    
                    // Clear the form
                    document.getElementById('addComponentForm').reset();
                    
                    // Show success message
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    </script>
</body>
</html>





