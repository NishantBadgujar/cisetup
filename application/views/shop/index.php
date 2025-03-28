<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Management</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
  <!-- Google Fonts: Cookie for headings and Poppins for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* Cake shop background image with pastel overlay */
    body {
      background: url('https://images.unsplash.com/photo-1505253210340-9d3f8a74c1b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      color: #333;
      transition: background 0.5s ease;
    }
    .overlay {
      background: rgba(255, 240, 245, 0.9); /* Pastel overlay for readability */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    /* Container Styling */
    .container {
      width: 100%;
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
      backdrop-filter: blur(10px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeInUp 0.6s ease-in-out;
    }
    /* Heading using Cookie font */
    h2 {
      font-family: 'Cookie', cursive;
      font-size: 2.8rem;
      color: #B03060; /* Rich cake-shop pink */
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-bottom: 20px;
      animation: slideInFromLeft 0.5s ease-in-out;
    }
    /* Table Styling */
    .table {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 8px;
      overflow: hidden;
      animation: fadeIn 0.5s ease-in-out;
    }
    .table thead {
      background: linear-gradient(135deg, #000080, #87CEEB); /* Navy blue to sky blue gradient */
      color: white;
      text-align: center;
    }
    .table tbody tr {
      transition: all 0.3s;
    }
    .table tbody tr:hover {
      background: rgba(0, 0, 128, 0.1);
    }
    /* Add Button */
    .btn-add {
      background: linear-gradient(135deg, #000080, #87CEEB);
      color: white;
      font-weight: bold;
      padding: 12px 20px;
      border-radius: 8px;
      transition: all 0.3s;
      animation: fadeIn 0.5s ease-in-out;
    }
    .btn-add:hover {
      background: linear-gradient(135deg, #87CEEB, #000080);
      transform: translateY(-2px);
      color: aliceblue;
    }
    /* Edit Button */
    .btn-edit {
      background: linear-gradient(135deg, #000080, #87CEEB);
      color: white;
      border-radius: 50%;
      transition: all 0.3s;
    }
    .btn-edit:hover {
      background: linear-gradient(135deg, #87CEEB, #000080);
      transform: scale(1.1);
      color: white;
    }
    /* Delete Button */
    .btn-delete {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
      border-radius: 50%;
      transition: all 0.3s;
    }
    .btn-delete:hover {
      background: linear-gradient(135deg, #c82333, #bd2130);
      transform: scale(1.1);
      color: white;
    }
    /* Table Icons */
    .icon {
      color: #000080;
      font-size: 16px;
      margin-right: 5px;
    }
    /* Password Toggle Button */
    .btn-toggle-password {
      background: linear-gradient(135deg, #6c757d, #5a6268);
      color: white;
      border-radius: 50%;
      transition: all 0.3s;
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
    }
    .btn-toggle-password:hover {
      background: linear-gradient(135deg, #5a6268, #494f54);
    }
    /* Password Cell */
    .password-cell {
      position: relative;
      padding-right: 40px;
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
  <h2 class="text-center mb-4"><i class="fas fa-store-alt"></i> Shop Management</h2>

  <a href="<?= base_url('shop/add') ?>" class="btn btn-add mb-3">
    <i class="fas fa-plus"></i> Add Shop
  </a>

  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th><i class="fas fa-hashtag icon"></i> SR No.</th>
        <th><i class="fas fa-cogs icon"></i> Shop Code</th>
        <th><i class="fas fa-store icon"></i> Name</th>
        <th><i class="fas fa-map-marker-alt icon"></i> Location</th>
        <th><i class="fas fa-key icon"></i> Password</th>
        <th><i class="fas fa-cogs icon"></i> Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($shops)) { $sr = 1; ?>
        <?php foreach ($shops as $shop) { ?>
          <tr>
            <td><?= $sr++; ?></td>
            <td><?= $shop['shop_code']; ?></td>
            <td><?= $shop['name']; ?></td>
            <td><?= $shop['location']; ?></td>
            <td class="password-cell">
              <span id="password-<?= $shop['id']; ?>" class="password-hidden"><?= str_repeat('*', strlen($shop['password'])); ?></span>
              <button class="btn btn-toggle-password btn-sm" onclick="togglePassword('<?= $shop['id']; ?>', '<?= $shop['password']; ?>')">
                <i class="fas fa-eye"></i>
              </button>
            </td>
            <td>
              <a href="<?= base_url('shop/edit/'.$shop['id']) ?>" class="btn btn-edit btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <a href="<?= base_url('shop/delete/'.$shop['id']) ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="text-center text-danger">
            <i class="fas fa-exclamation-circle"></i> No Shops Found
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  function togglePassword(shopId, password) {
    const passwordElement = document.getElementById('password-' + shopId);
    if (passwordElement.classList.contains('password-hidden')) {
      passwordElement.textContent = password;
      passwordElement.classList.remove('password-hidden');
    } else {
      passwordElement.textContent = '*'.repeat(password.length);
      passwordElement.classList.add('password-hidden');
    }
  }
</script>

</body>
</html>