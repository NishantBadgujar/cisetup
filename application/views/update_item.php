<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Background Gradient */
        body {
            background: #87CEEB; /* Solid sky blue background */
            font-family: 'Poppins', sans-serif;
            color: #333; /* Dark text for contrast */
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 1000px;
        }

        /* Heading */
        h2 {
            font-weight: bold;
            color: #000080; /* Navy blue for headings */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Label */
        .form-label {
            font-weight: bold;
            color: #000080; /* Navy blue for labels */
        }

        /* Input Fields */
        .form-control {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border */
            color: #333; /* Dark text for contrast */
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 1); /* Solid white on focus */
            border-color: #000080; /* Navy blue border on focus */
            box-shadow: 0px 0px 8px rgba(0, 0, 128, 0.3); /* Navy blue shadow */
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #000080, #87CEEB); /* Navy blue to sky blue gradient */
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #87CEEB, #000080); /* Reverse gradient on hover */
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #dc3545, #c82333); /* Red gradient */
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #c82333, #bd2130); /* Darker red gradient on hover */
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4"><i class="fas fa-edit"></i> Update Item</h2>

        <?php echo form_open('ShopInventory/update/' . $item->id); ?>

        <div class="mb-3">
            <label for="item_name" class="form-label"><i class="fas fa-cake"></i> Item Name:</label>
            <input type="text" id="item_name" name="item_name" class="form-control" value="<?php echo $item->item_name; ?>" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label"><i class="fas fa-sort-numeric-up"></i> Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo $item->quantity; ?>" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        <a href="<?= base_url('ShopInventory/view_shop_items') ?>" class="btn btn-secondary mt-2"><i class="fas fa-arrow-left"></i> Cancel</a>

        </form>
    </div>
</body>
</html>