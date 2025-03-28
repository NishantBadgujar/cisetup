<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management - Cake Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Manage Shops</h3>
        <!-- Add Shop Modal -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShopModal">Add Shop</button>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shops as $shop): ?>
                <tr>
                    <td><?= $shop->id ?></td>
                    <td><?= $shop->name ?></td>
                    <td><?= $shop->location ?></td>
                    <td>
                        <a href="<?= site_url('shop/edit_shop/'.$shop->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('shop/delete_shop/'.$shop->id) ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Shop Modal -->
        <div class="modal fade" id="addShopModal" tabindex="-1" aria-labelledby="addShopModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addShopModalLabel">Add New Shop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= site_url('shop/add_shop'); ?>" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Shop Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Shop</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
