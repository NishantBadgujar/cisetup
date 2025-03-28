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
  <title>Defected Products List</title>
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
    h3 {
      font-family: 'Cookie', cursive;
      font-size: 2.8rem;
      color: #B03060; /* Rich cake-shop pink */
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-bottom: 20px;
      animation: slideInFromLeft 0.5s ease-in-out;
    }
    .card {
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      overflow: hidden;
    }
    .card-header {
      background: linear-gradient(135deg, #B03060, #FFD1DC); /* Cake-shop inspired gradient */
      color: white;
    }
    .table {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 8px;
      overflow: hidden;
      animation: fadeIn 0.5s ease-in-out;
    }
    .table thead {
      background: linear-gradient(135deg, #B03060, #FFD1DC);
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
  <div class="container table-wrapper">
    <div class="card">
      <div class="card-header">
        <h3 class="mb-0">Defected Products</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th scope="col">Sr No.</th>
                <th scope="col">Shop Name</th>
                <th scope="col">Product Name</th>
                <th scope="col">Reason</th>
                <th scope="col">Quantity</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $cnt=0; foreach($products as $product){ ?>
              <tr>
                <th scope="row"><?php echo ++$cnt; ?></th>
                <td><?php echo $product['shop_code'];?></td>
                <td><?php echo $product["product_name"];?></td>
                <td><?php echo $product["reason"];?></td>
                <td><?php echo $product["quantity"];?></td>
                <td><?php echo $product["deleted_at"];?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
