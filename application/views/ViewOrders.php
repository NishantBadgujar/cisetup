<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts: Cookie for headings and Poppins for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <title>Users List</title>
  <style>
    body {
      /* Soft pastel background image for a cake shop vibe */
      background: url('https://images.unsplash.com/photo-1505253210340-9d3f8a74c1b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      color: #333;
      transition: background 0.5s ease;
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
    h2 {
      font-family: 'Cookie', cursive;
      font-size: 4rem;
      color: #B03060; /* Rich cake-shop pink */
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-bottom: 20px;
      animation: slideInFromLeft 0.5s ease-in-out;
    }
    .btn-success, .btn-danger {
      width: 70px;
      height: 35px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      border-radius: 8px;
      transition: all 0.3s;
      animation: fadeIn 0.5s ease-in-out;
    }
    .btn-success {
      background: linear-gradient(135deg, #28a745, #218838);
      color: white;
    }
    .btn-success:hover {
      background: linear-gradient(135deg, #218838, #28a745);
      transform: translateY(-2px);
      color: white;
    }
    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
      border: none;
    }
    .btn-danger:hover {
      background: linear-gradient(135deg, #c82333, #bd2130);
      transform: scale(1.1);
    }
    .table {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 8px;
      overflow: hidden;
      animation: fadeIn 0.5s ease-in-out;
    }
    .table thead {
      background: linear-gradient(135deg, #B03060, #FFD1DC); /* Cake-shop inspired gradient */
      color: white;
    }
    .table tbody tr {
      transition: all 0.3s;
    }
    .table tbody tr:hover {
      background: rgba(176, 48, 96, 0.1);
    }
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
    <h2 class="text-center mb-4">Orders</h2>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col">Sr No.</th>
            <th scope="col">Shop Name</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $cnt=0; foreach($orders as $order){ ?>
          <tr>
            <th scope="row"><?php echo ++$cnt; ?></th>
            <td><?php echo $order['shop_code'];?></td>
            <td><?php echo $order["name"];?></td>
            <td><?php echo $order["quantity"];?></td>
            <td><?php echo $order["created_at"];?></td>
            <td>
              <a href="<?= site_url('OrdersController/accept_order/'.$order['id']); ?>" class="btn btn-success btn-sm">Accept</a>
              <a href="<?= site_url('OrdersController/reject_order/'.$order['id']); ?>" class="btn btn-danger btn-sm">Reject</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
