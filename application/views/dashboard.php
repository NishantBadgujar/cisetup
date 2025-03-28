<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Inventory</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts: Cookie for headings and Poppins for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* Body with cake shop background image */
        body {
            background: url('https://images.unsplash.com/photo-1505253210340-9d3f8a74c1b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #333;
            transition: background 0.5s ease;
        }
        /* Overlay for readability */
        .overlay {
            background: rgba(255, 240, 245, 0.9);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        /* Container styling */
        .container {
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease-in-out;
        }
        /* Heading styling using Cookie font */
        h2 {
            font-family: 'Cookie', cursive;
            font-size: 2.8rem;
            color: #B03060; /* Rich cake-shop pink */
            text-align: center;
            margin-bottom: 20px;
            animation: slideInFromLeft 0.5s ease-in-out;
        }
        /* Select and form labels remain unchanged */
        .form-label {
            font-weight: bold;
        }
        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #B03060; /* Updated to cake-shop pink */
            color: #fff;
            font-weight: bold;
        }
        /* Stock Status */
        .low-stock { color: red; font-weight: bold; }
        .high-stock { color: lightgreen; font-weight: bold; }
        /* Chart Container */
        .chart-container {
            margin-top: 20px;
            animation: fadeInUp 0.6s ease-in-out;
        }
        /* Pie Chart */
        #distributionChart {
            max-width: 300px;
            margin: auto;
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
    <h2><i class="fas fa-box"></i> Shop Inventory</h2>
    <div class="mb-3">
        <label for="shopSelect" class="form-label">Select Shop:</label>
        <select id="shopSelect" class="form-select">
            <option value="">Select a shop</option>
            <?php foreach (array_unique(array_column($shops, 'shop_code')) as $code): ?>
                <option value="<?= htmlspecialchars($code) ?>"> <?= htmlspecialchars($code) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 chart-container">
            <canvas id="distributionChart"></canvas>
        </div>
        <div class="col-md-6 chart-container">
            <canvas id="quantityChart"></canvas>
        </div>
    </div>

    <div id="shopCards" class="mt-4">
        <?php
        $quantityData = [];
        foreach ($shops as $shop):
            $shopCode = $shop['shop_code'];
            if (!isset($quantityData[$shopCode])) {
                $quantityData[$shopCode] = 0;
            }
            $quantityData[$shopCode] += $shop['quantity'];
        ?>
            <div class="card p-3 mb-3" data-shop-code="<?= htmlspecialchars($shop['shop_code']) ?>">
                <div class="card-header">Shop <?= htmlspecialchars($shop['shop_code']) ?></div>
                <div class="card-body">
                    <p><strong>Item:</strong> <?= htmlspecialchars($shop['item_name']) ?></p>
                    <p><strong>Quantity:</strong> <span class="<?= ($shop['quantity'] < 11) ? 'low-stock' : 'high-stock' ?>">
                        <?= htmlspecialchars($shop['quantity']) ?></span>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const quantityDataJS = <?php echo json_encode($quantityData); ?>;

    const quantityCtx = document.getElementById('quantityChart').getContext('2d');
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');

    const quantityChart = new Chart(quantityCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Quantity',
                data: [],
                backgroundColor: 'rgba(0, 0, 128, 0.6)',
                borderColor: 'rgba(0, 0, 128, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { labels: { color: '#333' } } }
        }
    });

    const distributionChart = new Chart(distributionCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(quantityDataJS),
            datasets: [{
                data: Object.values(quantityDataJS),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#333' } } }
        }
    });

    function updateQuantityChart(shopCode) {
        const mockData = [100, 150, 120, 180, 220, 280, 320]; // Example data
        quantityChart.data.datasets[0].data = mockData;
        quantityChart.update();
    }

    document.getElementById('shopSelect').addEventListener('change', function() {
        const selectedShop = this.value;
        document.querySelectorAll('.card').forEach((card, index) => {
            setTimeout(() => {
                card.style.display = (card.getAttribute('data-shop-code') === selectedShop) ? 'block' : 'none';
                card.style.opacity = 0;
                setTimeout(() => card.style.opacity = 1, 100);
            }, index * 100);
        });
        if (selectedShop) {
            updateQuantityChart(selectedShop);
        }
    });
</script>

</body>
</html>
