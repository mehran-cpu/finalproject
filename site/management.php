<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
        header("Location: login.php");
        exit();
    }
    ?>

    <h2>پنل مدیریت</h2>
    <p>به پنل مدیریت خوش آمدید!</p>
    

 <?php 
ob_start(); // فعال کردن بافر خروجی
include 'header.php'; 
include 'confing3.php';

// دریافت لیست محصولات
try {
    $stmt = $conn->query("SELECT * FROM sports_supplements ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ خطا در دریافت محصولات: " . $e->getMessage());
}


// افزودن محصول جدید
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // آپلود عکس
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    // ذخیره در دیتابیس
    $stmt = $conn->prepare("INSERT INTO sports_supplements (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $imagePath]);

    header("Location: management.php");
    exit;
}

// حذف محصول
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM sports_supplements WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: management.php");
    exit;
}

// دریافت اطلاعات محصول برای ویرایش
$edit_product = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM sports_supplements WHERE id = ?");
    $stmt->execute([$id]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ویرایش محصول
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // بررسی آپلود عکس جدید
    if ($_FILES['image']['size'] > 0) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $stmt = $conn->prepare("UPDATE sports_supplements SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->execute([$name, $description, $price, $imagePath, $id]);
    } else {
        $stmt = $conn->prepare("UPDATE sports_supplements SET name=?, description=?, price=? WHERE id=?");
        $stmt->execute([$name, $description, $price, $id]);
    }

    header("Location: management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت محصولات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-card .card-body {
            padding: 1.5rem;
        }
        .product-card .card-title {
            font-size: 1.25rem;
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
            font-size: 1.1rem;
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

    <h2 class="mb-4 text-center">مدیریت محصولات</h2>

    <!-- فرم افزودن/ویرایش محصول -->
    <form action="management.php" method="post" enctype="multipart/form-data" class="mb-4">
        <input type="hidden" name="id" value="<?= $edit_product['id'] ?? '' ?>">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="نام محصول" value="<?= $edit_product['name'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="description" class="form-control" placeholder="توضیحات محصول" value="<?= $edit_product['description'] ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="price" class="form-control" placeholder="قیمت" value="<?= $edit_product['price'] ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <input type="file" name="image" class="form-control" <?= $edit_product ? '' : 'required' ?>>
            </div>
            <div class="col-md-2">
                <?php if ($edit_product): ?>
                    <button type="submit" name="edit_product" class="btn btn-warning w-100">ویرایش محصول</button>
                    <a href="management.php" class="btn btn-secondary w-100 mt-2">لغو</a>
                <?php else: ?>
                    <button type="submit" name="add_product" class="btn btn-success w-100">افزودن محصول</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- نمایش محصولات -->
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="price"><?= number_format($product['price']) ?> تومان</p>
                        <a href="management.php?edit=<?= $product['id'] ?>" class="btn btn-warning btn-sm mt-2">ویرایش</a>
                        <a href="management.php?delete=<?= $product['id'] ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('آیا از حذف این محصول مطمئن هستید؟');">حذف</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

<?php 
ob_end_flush(); // ارسال محتوای صفحه به مرورگر
include 'footer.php'; 
?>
