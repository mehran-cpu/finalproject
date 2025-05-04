<?php
session_start();
include 'confing3.php';
include 'header.php';

// بررسی ورود کاربر و وجود آیتم در سبد خرید
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    echo '<div class="alert alert-danger text-center fs-5 mt-5">⚠️ برای ثبت سفارش، ابتدا باید وارد حساب خود شوید و محصولی به سبد اضافه کرده باشید.</div>';
    include 'footer.php';
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total = 0;

// محاسبه مجموع کل
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// ثبت سفارش در جدول orders
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, order_date) VALUES (?, ?, NOW())");
$stmt->execute([$user_id, $total]);
$order_id = $conn->lastInsertId();

// ثبت اقلام سفارش در جدول order_items
foreach ($cart as $product_id => $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $product_id, $item['quantity'], $item['price']]);
}

// پاک کردن سبد خرید بعد از ثبت
unset($_SESSION['cart']);
?>

<!-- نمایش پیام موفقیت -->
<div class="container py-5 text-center">
    <div class="alert alert-success fs-4">
        ✅ سفارش شما با موفقیت ثبت شد!
    </div>
    <a href="index.php" class="btn btn-primary">بازگشت به صفحه اصلی</a>
</div>

<?php include 'footer.php'; ?>
