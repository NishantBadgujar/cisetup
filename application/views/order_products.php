<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Orders List</title>
  <style>
    body {
      background-color: #121212;
      background-attachment: fixed;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow-y: auto;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 95%;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      animation: fadeIn 0.5s ease-in-out;
    }

    .page-title {
      text-align: center;
      font-size: 32px;
      font-weight: bold;
      color: #e74c3c;
      text-transform: uppercase;
      padding: 20px 0;
      margin-bottom: 20px;
      border-bottom: 2px solid #e9ecef;
    }

    .table {
      border-radius: 10px;
      overflow: hidden;
      background: white;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .table th {
      background: black;
      color: white;
      text-transform: uppercase;
      text-align: center;
      font-weight: 600;
      padding: 15px;
    }

    .table td {
      text-align: center;
      vertical-align: middle;
      padding: 12px;
      color: #495057;
    }

    .table-hover tbody tr:hover {
      background: #f8f9fa;
      transition: 0.3s;
    }

    .btn-danger {
      background-color: #e74c3c;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      transition: 0.3s;
    }

    .btn-danger:hover {
      background-color: #c0392b;
      transform: translateY(-2px);
    }

    .alert {
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      border-color: #c3e6cb;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }

    .fa {
      margin-right: 8px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .table-responsive {
      overflow-x: auto;
    }

    @media (max-width: 768px) {
      .page-title {
        font-size: 26px;
      }
    }

    @media (max-width: 576px) {
      .page-title {
        font-size: 22px;
      }
      .table thead {
        display: none;
      }
      .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
      }
      .table tr {
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        background: white;
        padding: 10px;
      }
      .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        text-align: center;
      }
      .table td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 50%;
        font-weight: bold;
        color: #343a40;
        text-align: left;
      }
    }

    .table td[data-label="Msg"] {
      max-width: 200px;
      word-wrap: break-word;
      white-space: normal;
      overflow-wrap: break-word;
    }

    .msg-box {
      max-height: 100px;
      overflow-y: auto;
      padding: 5px;
      border-radius: 5px;
      background: rgba(255, 255, 255, 0.2);
      text-align: left;
    }

    .low-stock {
      background: linear-gradient(45deg, rgb(244, 84, 84), #ff9999) !important;
      color: #fff !important;
      font-weight: bold !important;
      border: 2px solid #ff0000 !important;
      padding: 5px;
      border-radius: 5px;
      animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        box-shadow: 0 0 5px #ff4d4d;
      }
      50% {
        transform: scale(1.05);
        box-shadow: 0 0 15px #ff4d4d;
      }
      100% {
        transform: scale(1);
        box-shadow: 0 0 5px #ff4d4d;
      }
    }

    .status-accepted {
      color: green;
      font-weight: bold;
    }

    .status-rejected {
      color: red;
      font-weight: bold;
    }

    .fab {
      position: fixed;
      right: 30px;
      bottom: 30px;
      background-color: #e74c3c;
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .fab:hover {
      background-color: #c0392b;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
      transform: translateY(-5px);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php
        $success = $this->session->userdata('success');
        if ($success != "") { ?>
          <div class="alert alert-success"> <?php echo $success; ?> </div>
        <?php } ?>

        <?php
        $failure = $this->session->userdata('failure');
        if ($failure != "") { ?>
          <div class="alert alert-danger"> <?php echo $failure; ?> </div>
        <?php } ?>
      </div>
    </div>

    <div class="row align-items-center mt-4">
      <div class="col-md-12 text-center">
        <h2 class="page-title"><i class="fa fa-list"></i> Orders</h2>
      </div>
    </div>
    <hr>

    <div class="row mt-4">
      <div class="col-md-12 mx-auto">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><i class="fas fa-user pe-1"></i> Sr No.</th>
                <th><i class="fa-solid fa-tag pe-1"></i> Name</th>
                <th><i class="fa-solid fa-boxes-stacked pe-1"></i> Quantity</th>
                <th><i class="fas fa-cogs pe-1"></i> Status</th>
                <th><i class="fa-solid fa-calendar pe-1"></i> Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $cnt = 0; foreach ($orders as $order) { ?>
                <tr>
                  <td data-label="Sr No."><?php echo ++$cnt; ?></td>
                  <td data-label="Name"><?php echo htmlspecialchars($order["name"]); ?></td>
                  <td data-label="Quantity"><?php echo htmlspecialchars($order["quantity"]); ?></td>
                  <td data-label="Status" class="<?php echo ($order['status'] == 'Accepted') ? 'status-accepted' : 'status-rejected'; ?>">
                    <?php echo htmlspecialchars($order["status"]); ?>
                  </td>
                  <td data-label="Date"><?php echo htmlspecialchars($order["updated_at"]); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="fab" id="openModalButton" onclick="OrderItems()">+</div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content shadow-lg border-0 rounded-3">
        <form action="<?php echo base_url().'ProductController/orderProduct'; ?>" method="post">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="exampleModalLabel">Order New Product</h5>
          </div>
          <div class="modal-body bg-light">
            <div class="form-group mb-3">
              <label for="name" class="form-label fw-bold">Product Name</label>
              <input type="text" name="name" placeholder="Enter product name here" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label for="quantity" class="form-label fw-bold">Quantity</label>
              <input type="text" name="quantity" placeholder="Enter quantity here" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="insert" value="Order Product" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if ($this->session->flashdata('error')): ?>
    <div align="center" style="color:#FFF" class="bg-danger">
      <?php echo $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('inserted')): ?>
    <div align="center" style="color:#FFF" class="bg-success">
      <?php echo $this->session->flashdata('inserted'); ?>
    </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('openModalButton').addEventListener('click', function () {
      const exampleModal = new bootstrap.Modal(document.getElementById('exampleModal'));
      exampleModal.show();
    });
  </script>
</body>
</html>
