<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Items to Shop</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- Google Fonts: Cookie and Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
      body {
          /* Cake shop background image with fixed cover */
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
          max-width: 1000px;
          background: rgba(255, 255, 255, 0.95);
          padding: 30px;
          border-radius: 12px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          margin-top: 50px;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          animation: fadeInUp 0.6s ease-in-out;
      }
      h2 {
          font-family: 'Cookie', cursive;
          font-size: 2.8rem;
          color: #B03060; /* Rich cake-shop pink */
          text-align: center;
          margin-bottom: 20px;
          animation: slideInFromLeft 0.5s ease-in-out;
      }
      .form-control:focus {
          border-color: #B03060;
          box-shadow: 0px 0px 8px rgba(176, 48, 96, 0.3);
      }
      .btn-primary {
          background: linear-gradient(135deg, #B03060, #FFD1DC);
          color: white;
          font-weight: bold;
          width: 100%;
          animation: fadeIn 0.5s ease-in-out;
          border: none;
      }
      .btn-primary:hover {
          background: linear-gradient(135deg, #FFD1DC, #B03060);
          transform: translateY(-2px);
      }
      .text-danger {
          display: none;
          animation: fadeIn 0.5s ease-in-out;
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
      <h2><i class="fas fa-box"></i> Assign Items to Shop</h2>

      <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success" role="alert">
              <?= $this->session->flashdata('success') ?>
          </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger" role="alert">
              <?= $this->session->flashdata('error') ?>
          </div>
      <?php endif; ?>

      <form action="<?= site_url('shopinventory/save_assigned_items') ?>" method="post" id="assignForm">
          <div class="mb-3">
              <label class="form-label">Shop:</label>
              <select name="shop_code" id="shop_code" class="form-control" required>
                  <option value="">Select a shop</option>
                  <?php foreach ($shops as $shop): ?>
                      <option value="<?= $shop->shop_code ?>"> <?= $shop->shop_code ?> </option>
                  <?php endforeach; ?>
              </select>
          </div>

          <div class="mb-3">
              <label class="form-label">Item:</label>
              <select name="item_name" id="item_name" class="form-control" required>
                  <option value="">Select an item</option>
                  <?php foreach ($items as $item): ?>
                      <!-- Added data-price and data-quantity attributes -->
                      <option value="<?= $item->item_name ?>" data-quantity="<?= $item->quantity ?>" data-price="<?= $item->price ?>">
                        <?= $item->item_name ?>
                      </option>
                  <?php endforeach; ?>
              </select>
          </div>

          <!-- Hidden input to post the price -->
          <input type="hidden" name="price" id="price" value="">

          <div class="mb-3">
              <label class="form-label">Quantity:</label>
              <input type="number" name="quantity" id="quantity" class="form-control" min="0" required>
              <div id="quantityError" class="text-danger mt-2">Quantity exceeds available inventory.</div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Assign Item
          </button>
      </form>
  </div>
  <script>
      // Update hidden price field when an item is selected
      document.getElementById('item_name').addEventListener('change', function() {
          let selectedItem = this.options[this.selectedIndex];
          let price = selectedItem.getAttribute('data-price') || '';
          document.getElementById('price').value = price;
      });

      document.getElementById('assignForm').addEventListener('submit', async function(event) {
          event.preventDefault();

          let itemSelect = document.getElementById('item_name');
          let selectedItem = itemSelect.options[itemSelect.selectedIndex];

          // Update hidden price field on submit to ensure the value is current
          let price = selectedItem.getAttribute('data-price') || '';
          document.getElementById('price').value = price;

          let availableQuantity = parseInt(selectedItem.getAttribute('data-quantity'));
          let requestedQuantity = parseInt(document.getElementById('quantity').value);
          let shopCode = document.getElementById('shop_code').value;

          if (!shopCode || !selectedItem.value || isNaN(requestedQuantity) || requestedQuantity <= 0) {
              alert('Please fill all fields correctly.');
              return;
          }

          try {
              const response = await fetch('<?= site_url('shopinventory/get_total_assigned_quantity') ?>', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ item_name: selectedItem.value, shop_code: shopCode })
              });

              const data = await response.json();
              let totalAssignedQuantity = data.total_assigned_quantity || 0;

              if (requestedQuantity + totalAssignedQuantity > availableQuantity) {
                  document.getElementById('quantityError').style.display = 'block';
              } else {
                  document.getElementById('quantityError').style.display = 'none';
                  this.submit();
              }
          } catch (error) {
              console.error('Error:', error);
              document.getElementById('quantityError').style.display = 'block';
          }
      });
  </script>
</body>
</html>
