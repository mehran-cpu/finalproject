<?php 
session_start();
include 'header.php'; 
include 'confing3.php';

// اگر کاربر وارد نشده باشد، نمایش پیغام و جلوگیری از ادامه
if (!isset($_SESSION['user_id'])) {
    echo '<div class="alert alert-danger text-center m-5 fs-5">⚠️ برای دسترسی به سبد خرید، ابتدا باید وارد حساب کاربری خود شوید.</div>';
    include 'footer.php';
    exit();
}

// افزودن یا افزایش تعداد
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM sports_supplements WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
}

// کاهش تعداد
if (isset($_GET['action']) && $_GET['action'] === 'decrease' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']--;
        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
}

// حذف محصول
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    unset($_SESSION['cart'][$id]);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سبد خرید</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">🛒 سبد خرید</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle bg-white shadow">
                <thead class="table-warning">
                    <tr>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>تعداد</th>
                        <th>قیمت واحد</th>
                        <th>قیمت کل</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" width="60" height="60" class="rounded"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="cart.php?action=decrease&id=<?= $id ?>" class="btn btn-outline-secondary btn-sm">-</a>
                                    <span class="btn btn-outline-dark btn-sm disabled"><?= $item['quantity'] ?></span>
                                    <a href="cart.php?action=add&id=<?= $id ?>" class="btn btn-outline-warning btn-sm">+</a>
                                </div>
                            </td>
                            <td><?= number_format($item['price']) ?> تومان</td>
                            <td><?= number_format($item['price'] * $item['quantity']) ?> تومان</td>
                            <td>
                                <a href="cart.php?action=remove&id=<?= $id ?>" class="btn btn-danger btn-sm">🗑 حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-light">
                        <td colspan="4" class="text-end fw-bold">مجموع کل:</td>
                        <td colspan="2" class="fw-bold text-success"><?= number_format($total) ?> تومان</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center">
                            <form action="submit_order.php" method="post">
                                <button type="submit" class="btn btn-success btn-lg mt-3">ثبت سفارش ✅</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center fs-5">سبد خرید شما خالی است.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
