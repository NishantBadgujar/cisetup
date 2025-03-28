<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Billing System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Fullscreen Background */
        body {
            background-color: #121212;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .form-check {
            color: #e0e0e0;
        }

        /* Centering Container */
        .container {
            max-width: 95%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Heading Styling */
        .page-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #e74c3c;
            text-transform: uppercase;
            padding: 15px 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        h3 {
            color: #e74c3c;
            font-size: 28px;
            text-align: center;
            margin: 20px 0;
        }

        /* Button Styles */
        .btn {
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .btn-success {
            background-color: #2ecc71;
            border: none;
        }

        .btn-success:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        /* Input Field Styling */
        input, select {
            background: #121212;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select {
            color: #e0e0e0;
        }

        input:focus, select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: #e74c3c;
        }

        /* Table Styling */
        .table {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #e0e0e0;
        }

        .table th {
            background: #121212;
            color: #e74c3c;
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .table td {
            background: rgba(255, 255, 255, 0.1);
            color: black;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Table */
        .table-responsive {
            overflow-x: auto;
        }

        /* Responsive Adjustments */
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
                border: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.1);
                padding: 10px;
            }
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 50%;
                font-weight: bold;
                color: #e0e0e0;
                text-align: left;
            }
        }

        /* Improve visibility and remove delay */
        .form-check-input {
            width: 20px;
            height: 20px;
            accent-color: #e74c3c; /* Color of the checkbox when checked */
            border: 2px solid #e74c3c; /* Make it visible */
            appearance: none; /* Remove default browser styles */
            background-color: transparent;
            display: inline-block;
            position: relative;
            transition: none !important; /* Remove delay */
        }

        /* Custom checkmark - appears instantly */
        .form-check-input:checked {
            background-color: #e74c3c !important; /* Instantly apply background */
            border-color: #e74c3c !important;
        }

        /* Force the checkmark to appear immediately */
        .form-check-input:checked::before {
            content: '\2713'; /* Unicode checkmark */
            font-size: 16px;
            font-weight: bold;
            color: white;
            position: absolute;
            left: 4px;
            top: 1px;
        }

        /* Prevent unwanted focus delay */
        .form-check-input:focus {
            box-shadow: none !important;
            outline: none !important;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="page-title"><i class="fa fa-list"></i> Products Billing</h1>

        <?php if ($this->session->flashdata('success')) echo '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>'; ?>
        <?php if ($this->session->flashdata('error')) echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>'; ?>

        <!-- Add Item Form -->
        <form method="post" action="<?= site_url('Billing/add_item'); ?>" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select name="name" id="product_select" class="form-control" required>
                        <option value="">Select Item</option>
                        <?php
                        $shop_code = $this->session->userdata('shop_code'); // for getting the logged-in shop ID
                        $this->db->where('shop_code', $shop_code);

                        if ($this->db->table_exists('shop_inventory')) {
                            $products = $this->db->get('shop_inventory')->result_array();
                            foreach ($products as $product):
                        ?>
                            <option value="<?= $product['item_name']; ?>" data-id="<?= $product['id']; ?>">
                                <?= $product['item_name']; ?>
                            </option>
                        <?php
                            endforeach;
                        } else {
                            echo '<option disabled>Products table not found</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="price" step="0.01" placeholder="Price" class="form-control" readonly required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="gst" step="0.01" placeholder="GST (%)" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="quantity" step="0.01" placeholder="Quantity" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-auto">Add Item</button>
        </form>

        <h3>Menu Items</h3>
        <form method="post" action="<?= site_url('Billing/generate_bill'); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-check-square"></i></th> <!-- Checkbox Column -->
                                    <th><i class="fa fa-utensils"></i> Name</th>
                                    <th><i class="fa fa-rupee-sign"></i> Price</th>
                                    <th><i class="fa fa-percent"></i> GST</th>
                                    <th>Quantity</th>
                                    <th><i class="fa fa-trash-alt"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td data-label="Select">
                                            <input class="form-check-input" type="checkbox" name="items[]" value="<?= $item['id']; ?>">
                                        </td>
                                        <td data-label="Name"><?= $item['name']; ?></td>
                                        <td data-label="Price">₹<?= number_format($item['price'], 2); ?></td>
                                        <td data-label="GST"><?= $item['gst']; ?>%</td>
                                        <td data-label="Quantity"><?= $item['quantity']; ?></td>
                                        <td data-label="Action">
                                            <a href="<?= site_url('Billing/delete_item/'.$item['id']); ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Generate Bill Button -->
            <button type="submit" class="btn btn-success w-auto mt-2">
                <i class="fa fa-file-invoice-dollar"></i> Generate Bill
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_select').change(function() {
                var productName = $(this).val(); // Get selected product name

                if (productName) {
                    $.ajax({
                        url: "<?= site_url('Billing/get_product_price'); ?>", // Controller method to fetch price
                        type: "POST",
                        data: { product_name: productName },
                        dataType: "json",
                        success: function(response) {
                            if (response.status) {
                                $('input[name="price"]').val(response.price).prop('readonly', true); // Set price and make it readonly
                            } else {
                                alert("Price not found for selected product");
                                $('input[name="price"]').val("").prop('readonly', false); // Allow editing if no price found
                            }
                        },
                        error: function() {
                            alert("Error fetching price");
                            $('input[name="price"]').val("").prop('readonly', false);
                        }
                    });
                } else {
                    $('input[name="price"]').val("").prop('readonly', false); // Reset field when no product is selected
                }
            });
        });
    </script>
</body>
</html>
