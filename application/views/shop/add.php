<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Shop</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- Google Fonts: Cookie for headings and Poppins for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* Cake shop background image with overlay for a warm, pastel vibe */
    body {
      background: url('https://images.unsplash.com/photo-1505253210340-9d3f8a74c1b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      color: #333;
      transition: background 0.5s ease;
      /* Ensure full height for vertical centering */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .overlay {
      /* Pastel overlay for readability */
      background: rgba(255, 240, 245, 0.9);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    .container {
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
      backdrop-filter: blur(10px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeInUp 0.6s ease-in-out;
    }
    /* Heading styling using Cookie font */
    h2 {
      font-family: 'Cookie', cursive;
      font-size: 2.8rem;
      color: #B03060; /* Rich cake-shop pink */
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-bottom: 20px;
      animation: slideInFromLeft 0.5s ease-in-out;
    }
    /* Form Label styling */
    .form-label {
      font-weight: bold;
      color: #000080; /* Navy blue for labels */
    }
    /* Input Fields */
    .form-control {
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(0, 0, 0, 0.1);
      color: #333;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s;
    }
    .form-control:focus {
      background: #fff;
      border-color: #000080;
      box-shadow: 0px 0px 8px rgba(0, 0, 128, 0.3);
    }
    /* Primary Button styling with cake shop gradient */
    .btn-primary {
      background: linear-gradient(135deg, #B03060, #FFD1DC);
      color: white;
      font-weight: bold;
      padding: 12px 20px;
      border-radius: 8px;
      transition: all 0.3s;
      width: 100%;
      border: none;
      animation: fadeIn 0.5s ease-in-out;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #FFD1DC, #B03060);
      transform: translateY(-2px);
    }
    /* Icon inside Input Group */
    .input-group-text {
      background: rgba(0, 0, 128, 0.1);
      color: #000080;
      border: none;
    }
    .btn-primary i {
      margin-right: 8px;
    }
    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
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

<div class="overlay"></div>
<div class="container">
  <h2 class="text-center mb-4"><i class="fas fa-store-alt"></i> Add New Shop</h2>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('shop/insert') ?>" method="POST" class="mt-4">
    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-barcode"></i></span>
      <input type="text" name="shop_code" class="form-control" placeholder="Shop Code" required>
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-store"></i></span>
      <input type="text" name="name" class="form-control" placeholder="Shop Name" required>
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
      <input type="text" name="location" class="form-control" placeholder="Location" required>
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-key"></i></span>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Shop</button>
  </form>
</div>

</body>
</html>
