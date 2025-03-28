<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Details</title>

    <!-- Bootstrap & FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Fullscreen Background */
        body {
            background: #333;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        /* Centering Container */
        .container {
            max-width: 95%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Heading Styling */
        .page-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            padding: 15px 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
        .table {
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .table th {
            background: #007bff;
            color: white;
            text-transform: uppercase;
        }

        .table-hover tbody tr:hover {
            background: #f8f9fa;
            transition: 0.3s;
        }

        /* Icon Styling */
        .fa {
            margin-right: 8px;
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
                border: 1px solid #ddd;
                border-radius: 10px;
                background: #fff;
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
                color: #333;
                text-align: left;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Bill Title -->
        <h1 class="page-title"><i class="fa fa-file-invoice"></i> Bill Details</h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th><i class="fa fa-check-square"></i></th> <!-- Checkbox Column -->
                                <th><i class="fa fa-utensils"></i> Name</th>
                                <th><i class="fa fa-tag"></i> Price</th>
                                <th><i class="fa fa-percent"></i> GST</th>
                                <th>Quantity</th>
                                <th><i class="fa fa-money-bill-alt"></i> Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $bill_items = json_decode($bill['items'], true);
                            foreach ($bill_items as $item):
                                $gst_amount = (($item['price'] * $item['quantity']) * $item['gst']) / 100;
                                $total_price = ($item['price'] * $item['quantity']) + $gst_amount;
                                $total += $total_price;
                            ?>
                                <tr>
                                    <td data-label="Select">
                                        <input class="form-check-input" type="checkbox" name="items[]" value="<?= $item['id']; ?>">
                                    </td>
                                    <td data-label="Name"><?= $item['name']; ?></td>
                                    <td data-label="Price">₹<?= number_format($item['price'], 2); ?></td>
                                    <td data-label="GST"><?= $item['gst']; ?>%</td>
                                    <td data-label="Quantity"><?= $item['quantity']; ?></td>
                                    <td data-label="Total">₹<?= number_format($total_price, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th colspan="5">Grand Total</th>
                                <th>₹<?= number_format($total, 2); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <button type="button" class="btn btn-primary w-auto mt-2" onclick="printInvoice()">
            <i class="fa fa-print"></i> Print Invoice
        </button>
    </div>

    <!-- Bootstrap & FontAwesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
function printInvoice() {
    // Get all selected checkboxes
    var selectedItems = $('input[name="items[]"]:checked');
    if (selectedItems.length === 0) {
        alert("Please select at least one item to print.");
        return;
    }

    // Create a new window for printing
    var printWindow = window.open('', '_blank');
    printWindow.document.open();

    // Write the HTML for the invoice
    printWindow.document.write('<html><head><title>Invoice</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Arial", sans-serif; margin: 20px; background-color: #f9f9f9; color: #333; }');
    printWindow.document.write('.invoice-container { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; }');
    printWindow.document.write('.invoice-header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.invoice-header h1 { color: #555; font-size: 28px; }');
    printWindow.document.write('.invoice-table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('.invoice-table th, .invoice-table td { padding: 15px; text-align: left; border: 1px solid #eee; }');
    printWindow.document.write('.invoice-table th { background-color: #f4f4f4; color: #666; font-weight: bold; }');
    printWindow.document.write('.invoice-table tfoot { font-weight: bold; background-color: #f9f9f9; }');
    printWindow.document.write('.invoice-total { text-align: right; margin-top: 20px; font-size: 18px; color: #555; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="invoice-container"><div class="invoice-header"><h1>Invoice</h1></div><table class="invoice-table"><thead><tr><th>Name</th><th>Price</th><th>GST</th><th>Quantity</th><th>Total</th></tr></thead><tbody>');

    var grandTotal = 0;

    // Add selected items to the invoice
    selectedItems.each(function() {
        var row = $(this).closest('tr');
        var name = row.find('td:eq(1)').text();
        var price = parseFloat(row.find('td:eq(2)').text().replace('₹', '').replace(',', ''));
        var gst = parseFloat(row.find('td:eq(3)').text());
        var quantity = parseFloat(row.find('td:eq(4)').text());

        var gstAmount = (price * gst) / 100;
        var total = price + gstAmount;
        grandTotal += total * quantity;

        printWindow.document.write('<tr><td>' + name + '</td><td>₹' + price.toFixed(2) + '</td><td>' + gst.toFixed(2) + '%</td><td>' + quantity + '</td><td>₹' + (total * quantity).toFixed(2) + '</td></tr>');
    });

    printWindow.document.write('</tbody><tfoot><tr><td colspan="4" class="invoice-total">Grand Total</td><td>₹' + grandTotal.toFixed(2) + '</td></tr></tfoot></table></div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Print the invoice
    printWindow.print();
}
</script>

    
</body>
</html>
