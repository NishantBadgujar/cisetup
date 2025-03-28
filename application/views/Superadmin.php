<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Set background gradient for the entire body */
        body {
            background: #87CEEB; /* Solid sky blue background */
            font-family: 'Poppins', sans-serif;
            color: #333; /* Dark text for contrast */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            transition: background 0.5s ease;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            background: rgba(144, 168, 190, 0.9); /* Semi-transparent white */
            backdrop-filter: blur(10px);
            padding: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            color: #333; /* Dark text for contrast */
            border-right: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border */
            animation: slideInFromLeft 0.5s ease-in-out;
        }

        .sidebar.active {
            width: 280px;
            box-shadow: 6px 0 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            color: #000080; /* Navy blue for headings */
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 0.5s ease-in-out;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            padding: 12px;
            border-left: 4px solid transparent;
            transition: background 0.3s, transform 0.2s, border-color 0.3s;
            border-radius: 8px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        .sidebar-menu li:nth-child(1) { animation-delay: 0.1s; }
        .sidebar-menu li:nth-child(2) { animation-delay: 0.2s; }
        .sidebar-menu li:nth-child(3) { animation-delay: 0.3s; }
        .sidebar-menu li:nth-child(4) { animation-delay: 0.4s; }
        .sidebar-menu li:nth-child(5) { animation-delay: 0.5s; }

        .sidebar-menu li:hover,
        .sidebar-menu li.active {
            background: rgba(0, 0, 128, 0.1); /* Light navy blue on hover */
            transform: scale(1.05);
            cursor: pointer;
            border-color: #000080; /* Navy blue border on hover */
        }

        .sidebar-menu li:hover::before,
        .sidebar-menu li.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #000080; /* Navy blue */
            transition: height 0.3s;
        }

        .sidebar-menu li a {
            text-decoration: none;
            color: #333; /* Dark text for contrast */
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            font-size: 18px;
            color: #000080; /* Navy blue icons */
        }

        /* Content area */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            color: #333; /* Dark text for contrast */
            backdrop-filter: blur(10px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease-in-out;
        }

        .main-content:hover {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border */
            background: rgba(255, 255, 255, 1); /* Solid white on hover */
        }

        iframe {
            width: 100%;
            height: 100vh;
            margin-left: 10px;
            border: none;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
        }

        /* Buttons */
        .menu-toggle {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #000080; /* Navy blue */
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            color: #fff; /* White text for contrast */
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .menu-toggle:hover {
            transform: translateY(-3px) scale(1.1);
            background: #87CEEB; /* Sky blue on hover */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInFromLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>
    <!-- Sidebar Section -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="#" onclick="loadPage('<?= site_url('Admin/dashboard'); ?>')"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('Shop/index'); ?>')"><i class="fas fa-store"></i> My Shops</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('Inventory/index'); ?>')"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('ShopInventory/assign_items'); ?>')"><i class="fas fa-dolly"></i> Distribute Items</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('ShopInventory/view_shop_items'); ?>')"><i class="fas fa-clipboard-list"></i> View Inventory</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('OrdersController/getOrders'); ?>')"><i class="fas fa-clipboard-list"></i> View Orders</a></li>
            <li><a href="#" onclick="loadPage('<?= site_url('OrdersController/deletedProducts'); ?>')"><i class="fas fa-clipboard-list"></i> Defected Products</a></li>
        </ul>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <iframe id="content-frame" src="<?= site_url('Admin/dashboard'); ?>"></iframe>
    </div>

    <script>
        function loadPage(page) {
            document.getElementById('content-frame').src = page;
            // Remove active class from all menu items
            document.querySelectorAll('.sidebar-menu li').forEach(li => li.classList.remove('active'));
            // Add active class to the clicked menu item
            event.target.closest('li').classList.add('active');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>
