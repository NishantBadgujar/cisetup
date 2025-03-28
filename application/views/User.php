<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  

    <style>
        .sidebar {
            background: linear-gradient(to top,rgb(22, 88, 154), #764ba2);
            
        }

        .sidebar-header h2{
            color: rgb(232, 199, 10); 
        }
        .sidebar-menu li a {
        background: linear-gradient(to right,rgb(39, 237, 217),rgb(103, 137, 174));
        color: black;
        /* background: black; */
        /* color: aqua; */
        }
    </style>
</head>
<body>
    <!-- Sidebar Section -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>User Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" onclick="loadPage('<?= site_url('AnalysisController'); ?>')"><i class="fas fa-tachometer-alt"></i> Analysis</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('ProductController/'); ?>')"><i class="fas fa-users"></i>Products</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('ProductController/'); ?>')"><i class="fas fa-users"></i>Order Products</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('Billing/'); ?>')"><i class="fas fa-file-invoice-dollar"></i>Create Bill</a></li>
        </ul>
        <button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <iframe id="content-frame" src="<?= site_url('AnalysisController'); ?>"></iframe>
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
