<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

ob_start();
include 'header.php';
include 'confing3.php';

// دریافت لیست محصولات
try {
    $stmt = $conn->query("SELECT * FROM sports_supplements ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ خطا در دریافت محصولات: " . $e->getMessage());
}

// دریافت لیست سفارشات
try {
    $stmt = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // گرفتن آیتم‌های سفارش
    $order_ids = array_column($orders, 'order_id');
    $order_items = [];

    if (!empty($order_ids)) {
        $in_query = implode(',', array_fill(0, count($order_ids), '?'));
        $stmt = $conn->prepare("
            SELECT oi.order_id, s.name AS product_name, oi.quantity 
            FROM order_items oi 
            JOIN sports_supplements s ON oi.product_id = s.id 
            WHERE oi.order_id IN ($in_query)
        ");
        $stmt->execute($order_ids);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $order_items[$item['order_id']][] = $item;
        }
    }
} catch (PDOException $e) {
    die("❌ خطا در دریافت سفارشات: " . $e->getMessage());
}

// افزودن محصول جدید
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    $stmt = $conn->prepare("INSERT INTO sports_supplements (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $imagePath]);

    header("Location: management.php");
    exit;
}

// حذف محصول + حذف عکس
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $stmt = $conn->prepare("SELECT image FROM sports_supplements WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && file_exists($product['image'])) {
        unlink($product['image']);
    }

    $stmt = $conn->prepare("DELETE FROM sports_supplements WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: management.php");
    exit;
}

// دریافت اطلاعات برای ویرایش
$edit_product = null;
if (isset($_GET['edit_product'])) {
    $id = $_GET['edit_product'];
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

// حذف سفارش
if (isset($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];
    try {
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        header("Location: management.php");
        exit;
    } catch (PDOException $e) {
        die("❌ خطا در حذف سفارش: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت محصولات و سفارشات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light container py-4">

    <h2 class="text-center mb-4">📦 پنل مدیریت محصولات و سفارشات</h2>

    <!-- مدیریت محصولات -->
    <div class="mb-5">
        <h3 class="text-center mb-4">مدیریت محصولات</h3>

        <form method="post" enctype="multipart/form-data" class="row g-3 bg-white p-4 rounded shadow-sm mb-5">
            <input type="hidden" name="id" value="<?= $edit_product['id'] ?? '' ?>">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="نام محصول" value="<?= $edit_product['name'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="description" class="form-control" placeholder="توضیحات" value="<?= $edit_product['description'] ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="price" class="form-control" placeholder="قیمت" value="<?= $edit_product['price'] ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <input type="file" name="image" class="form-control" <?= $edit_product ? '' : 'required' ?> />
            </div>
            <div class="col-md-2 d-grid">
                <?php if ($edit_product): ?>
                    <button type="submit" name="edit_product" class="btn btn-warning">✏️ ویرایش</button>
                    <a href="management.php" class="btn btn-secondary mt-2">لغو</a>
                <?php else: ?>
                    <button type="submit" name="add_product" class="btn btn-success">➕ افزودن</button>
                <?php endif; ?>
            </div>
        </form>

        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" style="height:200px; object-fit:cover;" alt="عکس محصول">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="text-warning fw-bold"><?= number_format($product['price']) ?> تومان</p>
                            <a href="management.php?edit_product=<?= $product['id'] ?>" class="btn btn-outline-warning btn-sm">✏️ ویرایش</a>
                            <a href="management.php?delete_product=<?= $product['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('آیا از حذف این محصول مطمئن هستید؟')">🗑 حذف</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- مدیریت سفارشات -->
    <div>
        <h3 class="text-center mb-4">مدیریت سفارشات</h3>

        <div class="row">
            <?php if (isset($orders) && is_array($orders) && count($orders) > 0): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">سفارش شماره: <?= htmlspecialchars($order['order_id']) ?></h5>
                                <p class="card-text text-muted">کاربر: <?= htmlspecialchars($order['user_id']) ?></p>
                                <p class="text-warning fw-bold">مجموع قیمت: <?= number_format($order['total_price']) ?> تومان</p>
                                <p class="text-muted">تاریخ سفارش: <?= htmlspecialchars($order['order_date']) ?></p>
                                <p class="text-muted">وضعیت: <?= htmlspecialchars($order['status']) ?></p>

                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <p class="text-muted">محصولات:
                                        <ul>
                                            <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                <li><?= htmlspecialchars($item['product_name']) ?> × <?= $item['quantity'] ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </p>
                                <?php else: ?>
                                    <p class="text-muted">محصولی ثبت نشده است.</p>
                                <?php endif; ?>

                                <a href="management.php?edit_order=<?= $order['order_id'] ?>" class="btn btn-outline-warning btn-sm">✏️ ویرایش</a>
                                <a href="management.php?delete_order=<?= $order['order_id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('آیا از حذف این سفارش مطمئن هستید؟')">🗑 حذف</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-warning">هیچ سفارشی یافت نشد.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php
ob_end_flush();
include 'footer.php';
?>
