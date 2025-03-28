<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analysis - Cake Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Sales Analysis</h3>
        <div class="row">
            <div class="col-md-12">
                <h4>Sales Overview</h4>
                <!-- Display Sales Data (Charts or Table) -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Total Sales</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= $sale->shop_name ?></td>
                            <td><?= $sale->total_sales ?></td>
                            <td><a href="#" class="btn btn-info btn-sm">View Details</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
