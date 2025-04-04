<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Shop Inventory</title>

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
        }
        .overlay {
            background: rgba(255, 240, 245, 0.9);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        /* Container Styling with soft pastel white */
        .container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.96);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 0.6s ease-in-out;
        }
        /* Heading with Cookie font and rich pink tone */
        h2 {
            font-family: 'Cookie', cursive;
            font-size: 2.8rem;
            color: #B03060; /* Rich cake-shop pink */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
            animation: slideInFromLeft 0.5s ease-in-out;
        }
        /* Alert Styling with a soft red gradient */
        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        /* Primary Button styling with a revised pastel gradient */
        .btn-primary {
            background: linear-gradient(135deg, #000080, #87CEEB);
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s;
            animation: fadeIn 0.5s ease-in-out;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #87CEEB, #000080);
            transform: translateY(-2px);
            color: aliceblue;
        }
        /* Warning Button remains similar */
        .btn-warning {
            background: linear-gradient(135deg, #000080, #87CEEB);
            color: white;
            border-radius: 50%;
            transition: all 0.3s;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #87CEEB, #000080);
            transform: scale(1.1);
            color: white;
        }
        /* Danger Button */
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: scale(1.1);
        }
        /* Table Styling with updated pastel header gradient */
        .table {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.5s ease-in-out;
        }
        .table thead {
            background: linear-gradient(135deg, #B03060, #FFD1DC); /* Rich to soft pink */
            color: white;
        }
        .table tbody tr {
            transition: all 0.3s;
        }
        .table tbody tr:hover {
            background: rgba(176, 48, 96, 0.1); /* Light pinkish hover */
        }
        /* Form Styling */
        .form-control {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            background: #fff;
            border-color: #B03060;
            box-shadow: 0px 0px 8px rgba(176, 48, 96, 0.3);
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
    <h2 class="text-center mb-4"><i class="fas fa-box"></i> Cake Shop Inventory</h2>

    <!-- Low Stock Warning -->
    <?php
    $lowStockItems = array_filter($items, function ($item) {
        return $item['quantity'] < 10;
    });
    if (!empty($lowStockItems)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Warning: Some items are running low on stock!
        </div>
    <?php endif; ?>

    <button id="addInventoryButton" class="btn btn-primary small-btn" onclick="toggleForm()">
        <i class="fas fa-plus-circle"></i> Add Inventory
    </button>

    <form method="post" action="<?php echo base_url('inventory/add_item'); ?>" id="addInventoryForm" style="display: none;" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price per product</label>
            <input type="number" name="price" class="form-control" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary small-btn">
            <i class="fas fa-plus-circle"></i> Add Item
        </button>
    </form>

    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i> Sr. No.</th>
                <th><i class="fas fa-cake"></i> Item Name</th>
                <th><i class="fas fa-cogs"></i> Quantity</th>
                <th><i class="fas fa-tag"></i> Price per product</th>
                <th><i class="fas fa-cogs"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sr_no = 1;
            foreach ($items as $item):
                $lowStockClass = ($item['quantity'] < 11) ? 'table-danger' : '';
            ?>
                <tr class="<?php echo $lowStockClass; ?>">
                    <td><?php echo $sr_no++; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="toggleEditForm(<?php echo $item['id']; ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="<?php echo base_url('inventory/delete_item/' . $item['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr id="editInventoryForm_<?php echo $item['id']; ?>" style="display: none;">
                    <td colspan="5">
                        <div class="edit-form-container">
                            <form method="post" action="<?php echo base_url('inventory/update_item/' . $item['id']); ?>" class="update-form">
                                <div class="mb-3">
                                    <label class="form-label">Item Name</label>
                                    <input type="text" name="item_name" class="form-control" value="<?php echo $item['item_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $item['quantity']; ?>" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" name="price" class="form-control" value="<?php echo $item['price']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Update Item
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleForm() {
        var form = document.getElementById("addInventoryForm");
        form.style.display = (form.style.display === "none") ? "block" : "none";
    }
    function toggleEditForm(itemId) {
        var form = document.getElementById("editInventoryForm_" + itemId);
        form.style.display = (form.style.display === "none") ? "table-row" : "none";
    }
</script>

</body>
</html>
