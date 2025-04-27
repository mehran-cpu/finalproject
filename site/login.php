<?php
session_start();
include 'db.php';  // اتصال به دیتابیس

// بررسی اینکه آیا فرم ارسال شده است یا نه
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // یا ایمیل
    $password = $_POST['password'];

    // جستجو در دیتابیس برای کاربر با این نام کاربری
    $sql = "SELECT * FROM register_login WHERE username = '$username' OR email = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // اگر کاربر پیدا شد
        $row = $result->fetch_assoc();
        
        // بررسی رمز عبور
        // if (password_verify($password, $row['password'])) {
        if ($password== $row['password']) {
            // ذخیره اطلاعات کاربر در سشن
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];  // نقش کاربر
            
            // بررسی نقش کاربر
            if ($row['role'] == 'admin') {
                header("Location: index.php");  // هدایت به داشبورد مدیر
                exit();
            } else {
                header("Location: index.php");  // هدایت به صفحه اصلی برای کاربران معمولی
                exit();
            }
        } else {
            $error_message = "رمز عبور اشتباه است.";
        }
    } else {
        $error_message = "کاربری با این نام کاربری پیدا نشد.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Page Header for Login -->
<header class="rtl custom-header py-5 text-white text-center" style="background: rgba(0, 0, 0, 0.7); direction: rtl; text-align: right;">
    <div class="container">
        <h1 class="display-4 fw-bold text-warning">ورود به حساب کاربری</h1>
        <p class="lead">لطفاً نام کاربری و رمز عبور خود را وارد کنید</p>
    </div>
</header>

<!-- Login Form Section -->
<div class="container content-section py-5" style="direction: rtl; text-align: right; margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);">
                <div class="card-header bg-dark text-warning fw-bold text-center">ورود به سایت</div>
                <div class="card-body" style="background: rgba(0, 0, 0, 0.5); color: #d1d1d1;">
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label text-warning">نام کاربری</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="نام کاربری خود را وارد کنید" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-warning">رمز عبور</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="رمز عبور خود را وارد کنید" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">ورود</button>
                    </form>
                    <?php
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger mt-3" role="alert">' . $error_message . '</div>';
                    }
                    ?>
                    <div class="text-center mt-3">
                        <a href="register.php" class="text-white">ثبت‌نام کنید</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
