<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cake Shop Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #1a1a1a;
      color: white;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.85);
      padding: 15px;
      z-index: 1000;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }
    .navbar-brand {
      font-weight: bold;
      color: #e74c3c !important;
      font-size: 1.8rem;
      text-transform: uppercase;
    }
    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
      margin-bottom: 20px;
    }
    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }
    .card-header {
      background-color: transparent;
      color: #e74c3c;
      font-weight: bold;
      font-size: 1.5rem;
      text-align: center;
    }
    .count {
      font-size: 3rem;
      font-weight: bold;
      color: #e74c3c;
      text-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
      text-align: center;
    }
   
    #productChart, #stockLevelsChart {
      max-width: 300px;
      max-height: 300px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Shop Dashboard</a>
    </div>
  </nav>

  <div class="container mt-5 pt-5">
    <!-- Product Wise Analysis Card (Now Month Wise Sales Chart) -->
    <div class="card">
      <div class="card-header">Product Wise Analysis</div>
      <div class="card-body d-flex justify-content-center">
        <canvas id="productChart"></canvas>
      </div>
    </div>

    <!-- Product Stock Status Card -->
    <div class="card">
      <div class="card-header">Product Stock Status</div>
      <div class="card-body d-flex justify-content-center">
        <canvas id="stockLevelsChart"></canvas>
      </div>
    </div>

    <div class="d-flex justify-content-around mt-4">
      <div class="card">
        <div class="card-header">Total Products</div>
        <div class="card-body">
          <h3 class="count" id="revenue">0</h3>
        </div>
      </div>
      <div class="card">
        <div class="card-header">Sell Products</div>
        <div class="card-body">
          <h3 class="count" id="orders">0 Orders</h3>
        </div>
      </div>
    </div>
  </div>

  <script>
    function animateValue(id, start, end, duration, prefix = '', suffix = '') {
      let range = end - start;
      let current = start;
      let increment = range / (duration / 50);
      let obj = document.getElementById(id);
      let timer = setInterval(function() {
        current += increment;
        if (current >= end) {
          current = end;
          clearInterval(timer);
        }
        obj.innerHTML = prefix + Math.floor(current) + suffix;
      }, 50);
    }

    window.onload = function () {
      // Animate counters
      animateValue("revenue", 0, <?php echo $product_count;?>, 500);
      animateValue("orders", 0, <?php echo $sell_count;?>, 1000);

      // Month Wise Sales Chart using data from 'generated_bills'
      const monthNames = <?php echo $month_names; ?>;
      const monthSales = <?php echo $month_sales; ?>;
      const productCtx = document.getElementById('productChart').getContext('2d');
      new Chart(productCtx, {
        type: 'bar',
        data: {
          labels: monthNames,
          datasets: [{
            label: 'Monthly Sales',
            data: monthSales,
            backgroundColor: 'rgba(231, 76, 60, 0.7)',
            borderColor: 'rgba(231, 76, 60, 1)',
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'x',
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: { color: 'white' }
            },
            x: {
              ticks: { color: 'white' }
            }
          },
          plugins: {
            legend: {
              labels: { color: 'white' }
            }
          }
        }
      });

      // Product Stock Status Chart
      const stockNames = <?php echo $product_stock_names; ?>;
      const stockQuantities = <?php echo $product_stock_quantities; ?>;
      
      const stockColors = stockQuantities.map(q => {
        if (q < 10) {
          return '#e74c3c'; // Out of stock: red
        } else if (q < 15) {
          return '#f39c12'; // Low stock: orange
        } else {
          return '#2ecc71'; // In stock: green
        }
      });

      const stockCtx = document.getElementById('stockLevelsChart').getContext('2d');
      new Chart(stockCtx, {
        type: 'bar',
        data: {
          labels: stockNames,
          datasets: [{
            label: 'Stock Quantity',
            data: stockQuantities,
            backgroundColor: stockColors,
            borderColor: stockColors,
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              ticks: { color: 'white' }
            },
            y: {
              ticks: { color: 'white' }
            }
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const qty = context.parsed.x;
                  let status = '';
                  if (qty == 0) {
                    status = 'Out of Stock';
                  } else if (qty < 10) {
                    status = 'Low Stock';
                  } else {
                    status = 'In Stock';
                  }
                  return `Quantity: ${qty} (${status})`;
                }
              }
            }
          }
        }
      });
    };
  </script>
</body>
</html>
