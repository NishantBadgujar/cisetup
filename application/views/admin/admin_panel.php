<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/styles.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar Section -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" onclick="loadPage('<?= site_url('Shop/index'); ?>')"><i class="fas fa-store-alt"></i> Shop Management</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('Sales/index'); ?>')"><i class="fas fa-chart-line"></i> Sales Analysis</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('admin/cake_inventory'); ?>')"><i class="fas fa-cake"></i> Cake Inventory</a></li>
        </ul>
        
        <button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <iframe id="content-frame" src="<?= site_url('admin/shop_management'); ?>" frameborder="0"></iframe>
    </div>

    <script>
        // Function to change the iframe's source dynamically
        function loadPage(page) {
            document.getElementById('content-frame').src = page;
        }

        // Function to toggle sidebar visibility on small screens
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>
