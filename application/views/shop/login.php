<!DOCTYPE html>
<html>
<head>
    <title>Shop Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card p-4" style="width: 350px;">
        <h3 class="text-center">Shop Login</h3>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <form action="<?php echo base_url('shop/authenticate'); ?>" method="post">
            <div class="mb-3">
                <label for="shop_code" class="form-label">Shop Code</label>
                <input type="text" class="form-control" id="shop_code" name="shop_code" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

</body>
</html>
