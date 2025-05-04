<?php include 'header.php'; ?>
<?php
include 'confing3.php'; // اتصال به دیتابیس

// دریافت لیست محصولات از دیتابیس
try {
    $stmt = $conn->query("SELECT * FROM sports_supplements ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ خطا در دریافت محصولات: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محصولات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* استایل برای کارت‌ها */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            width: 100%;  /* عرض تصویر به اندازه کامل کارت */
            max-height: 200px; /* محدود کردن ارتفاع تصویر */
            object-fit: contain; /* حفظ تناسب ابعاد تصویر */
            object-position: center center; /* موقعیت تصویر وسط کارت */
        }
        .product-card .card-body {
            padding: 1.5rem;
        }
        .product-card .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        .product-card .card-text {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
        }
        .product-card .price {
            font-size: 1.1rem;
            color: #e74c3c;
            font-weight: bold;
        }
        .buy-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .buy-btn:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body class="container mt-5">

    <h2 class="mb-4 text-center">لیست محصولات</h2>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="price"><?= number_format($product['price']) ?> تومان</p>
                        <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="buy-btn">خرید</a>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

<?php include 'footer.php'; ?>