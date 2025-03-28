<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            background:black;
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
        background: linear-gradient(45deg,rgb(244, 84, 84), #ff9999) !important;
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


   </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $success = $this->session->userdata('success');
                if($success != ""){ ?>
                    <div class="alert alert-success"> <?php echo $success; ?> </div>
                <?php } ?>

                <?php
                $failure = $this->session->userdata('failure');
                if($failure != ""){ ?>
                    <div class="alert alert-danger"> <?php echo $failure; ?> </div>
                <?php } ?>
            </div>
        </div>

        <div class="row align-items-center mt-4">
            <div class="col-md-12 text-center">
                <h2 class="page-title"><i class="fa fa-list"></i> Products</h2>
            </div>
        </div>
        <hr>

        <div class="row mt-4">
            <div class="col-md-12 mx-auto">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user pe-1"></i>ID</th>
                                <th><i class="fa-solid fa-tag pe-1"></i>Product Name</th>
                                <!-- <th><i class="fa-solid fa-audio-description pe-1"></i>Description</th> -->
                                <th><i class="fa-solid fa-money-check-dollar pe-1"></i>Price</th>
                                <th><i class="fa-solid fa-boxes-stacked pe-1"></i>Quantity</th>
                                <th width="120"><i class="fas fa-cogs pe-1"></i> Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    // Cast quantity to a number for safety
                                    $quantity = (float)$user['quantity'];
                                    $lowStockClass = ($quantity < 10) ? 'low-stock' : '';
                            ?>
                            <tr>
                                <td data-label="ID"><?php echo $count++; ?></td>
                                <td data-label="Product Name"><?php echo htmlspecialchars($user['item_name']); ?></td>
                                <!-- <td data-label="Description"><?php echo htmlspecialchars($user['description']); ?></td> -->
                                <td data-label="Price"><?php echo htmlspecialchars($user['price']); ?></td>
                                <td data-label="Quantity" class="<?php echo $lowStockClass; ?>">
                                    <?php echo htmlspecialchars($user['quantity']); ?>
                                </td>
                                <td data-label="Actions">
                                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $user['id']; ?>">
                                        <i class="fas fa-trash pe-2"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else { 
                            ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        input: 'text',
                        inputPlaceholder: 'Enter reason for deletion...',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to enter a reason!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const reason = result.value;
                            window.location.href = `<?php echo base_url(); ?>ProductController/delete/${productId}?reason=${encodeURIComponent(reason)}`;
                        }
                    });
                });
            });
        });

    </script>

</body>
</html>
