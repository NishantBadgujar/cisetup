<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shop Items</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Fonts: Cookie for headings and Poppins for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* Cake Shop Background with a pastel overlay */
        body {
            background: url('https://images.unsplash.com/photo-1559561853-d5a2b7bb561d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
            transition: background 0.5s ease;
        }
        .overlay {
            background: rgba(255, 240, 245, 0.95);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        /* Container Styling */
        .container {
            max-width: 1200px;
            padding: 30px;
            margin-top: 50px;
            animation: fadeInUp 1s ease-in-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Heading Styling */
        h2 {
            font-family: 'Cookie', cursive;
            font-weight: bold;
            font-size: 2.8rem;
            color: #C2185B; /* Deep pastel pink */
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        /* Shop Card Styling */
        .shop-card {
            background: linear-gradient(135deg, #ffffff, #ffe6f2); /* White to light pastel pink */
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 320px;
            width: 48%;
        }
        .shop-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        /* Item Card Styling */
        .item-card {
            background: rgba(255, 182, 193, 0.3); /* Soft pastel pink overlay */
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
        }
        /* Delete Button Styling */
        .btn-delete {
            color:rgb(69, 12, 5);
            background: none;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .btn-delete:hover {
            transform: scale(1.2);
        }
        /* Shop Cards Container */
        .shop-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h2><i class="fas fa-box"></i> Items Assigned to Shop</h2>

        <div class="mb-3">
            <label for="shopSelect" class="form-label">Select Shop:</label>
            <select id="shopSelect" class="form-select">
                <option value="">All Shops</option>
                <?php
                $shop_codes = array_unique(array_column($shop_items, 'shop_code'));
                foreach ($shop_codes as $code):
                    echo '<option value="' . htmlspecialchars($code) . '">' . htmlspecialchars($code) . '</option>';
                endforeach;
                ?>
            </select>
        </div>

        <div id="shopCards" class="shop-cards-container">
            <?php
            usort($shop_items, function($a, $b) {
                return strcmp($a->shop_code, $b->shop_code);
            });

            $current_shop_code = null;
            foreach ($shop_items as $item):
                if ($item->shop_code !== $current_shop_code):
                    if ($current_shop_code !== null) echo '</div></div>'; // Close previous card
                    $current_shop_code = $item->shop_code;
            ?>
                <div class="shop-card" data-shop-code="<?= htmlspecialchars($item->shop_code) ?>">
                    <h5><i class="fas fa-store"></i> Shop: <?= htmlspecialchars($item->shop_code) ?></h5>
                    <div class="shop-items">
            <?php endif; ?>
                        <div class="item-card">
                            <span><strong><?= htmlspecialchars($item->item_name) ?></strong> (<?= htmlspecialchars($item->quantity) ?> pcs)</span>
                            <span><small>Assigned On: <?= htmlspecialchars($item->y) ?></small></span>
                            <button class="btn-delete" onclick="confirmDelete('<?= base_url('shopinventory/delete/' . $item->id) ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
            <?php endforeach; ?>
                    </div>
                </div>
        </div>
    </div>

    <script>
        document.getElementById('shopSelect').addEventListener('change', function() {
            const selectedShop = this.value;
            document.querySelectorAll('.shop-card').forEach(card => {
                card.style.display = (selectedShop === '' || card.getAttribute('data-shop-code') === selectedShop) ? 'block' : 'none';
            });
        });

        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
