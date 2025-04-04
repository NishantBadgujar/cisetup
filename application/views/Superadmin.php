<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <!-- Google Fonts: Cookie for headings and Poppins for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

  <link rel="stylesheet" href="<?php echo base_url('assets/admin.css'); ?>" />

  <style>
    /* Body: Use a soft pastel background and Poppins font */
    body {
      background: #FFF0F5; /* Lavender blush background */
      font-family: 'Poppins', sans-serif;
      color: #333;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      transition: background 0.5s ease;
    }
    
    /* Sidebar Styling: Update to a semi-transparent white with subtle box-shadow, matching the inventory view */
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      background: rgba(255, 255, 255, 0.96);
      backdrop-filter: blur(10px);
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
      color: #333;
      border-right: 1px solid rgba(0, 0, 0, 0.1);
      animation: slideInFromLeft 0.5s ease-in-out;
    }
    
    .sidebar.active {
      width: 280px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Sidebar Header using Cookie font and rich pink tone */
    .sidebar h2 {
      font-family: 'Cookie', cursive;
      color: #B03060;
      text-align: center;
      font-size: 28px;
      margin-bottom: 20px;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      animation: fadeInDown 0.5s ease-in-out;
    }
    
    /* Sidebar Menu Styling */
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
    .sidebar-menu li:nth-child(6) { animation-delay: 0.6s; }
    .sidebar-menu li:nth-child(7) { animation-delay: 0.7s; }
    
    .sidebar-menu li:hover,
    .sidebar-menu li.active {
      background: rgba(176, 48, 96, 0.1); /* Light rich pink tint */
      transform: scale(1.05);
      cursor: pointer;
      border-color: #B03060;
    }
    
    .sidebar-menu li:hover::before,
    .sidebar-menu li.active::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: #B03060;
      transition: height 0.3s;
    }
    
    .sidebar-menu li a {
      text-decoration: none;
      color: #333;
      font-size: 16px;
      display: flex;
      align-items: center;
    }
    
    .sidebar-menu li a i {
      margin-right: 10px;
      font-size: 18px;
      color: #B03060;
    }
    
    /* Main Content: Similar semi-transparent container styling */
    .main-content {
      margin-left: 280px;
      padding: 30px;
      background: rgba(255, 255, 255, 0.96);
      border-radius: 12px;
      transition: all 0.3s ease-in-out;
      color: #333;
      backdrop-filter: blur(10px);
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 0.6s ease-in-out;
    }
    
    .main-content:hover {
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 1);
    }
    
    iframe {
      width: 100%;
      height: 100vh;
      margin-left: 10px;
      border: none;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 0.96);
    }
    
    /* Menu Toggle Button */
    .menu-toggle {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: #B03060;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }
    
    .menu-toggle:hover {
      transform: translateY(-3px) scale(1.1);
      background: #87CEEB;
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
    <button class="menu-toggle" onclick="toggleSidebar()">Menu</button>
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
