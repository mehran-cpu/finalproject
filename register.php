<?php
include 'header.php';
include 'db.php'; // اتصال به دیتابیس

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // بررسی اینکه نام کاربری یا ایمیل از قبل وجود نداشته باشد
    $check_sql = "SELECT * FROM register_login WHERE username='$username' OR email='$email'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger text-center'>نام کاربری یا ایمیل قبلاً ثبت شده است!</div>";
    } else {
        // هش کردن رمز عبور
        $hashed_password =$password;// password_hash($password, PASSWORD_DEFAULT);

        // ذخیره اطلاعات در دیتابیس
        $sql = "INSERT INTO register_login  (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success text-center'>ثبت‌نام با موفقیت انجام شد. <a href='login.php'>ورود به حساب</a></div>";
        } else {
            echo "<div class='alert alert-danger text-center'>خطا در ثبت‌نام: " . $conn->error . "</div>";
        }
    }
}
?>

<!-- فرم ثبت‌نام -->
<div class="container content-section py-5" style="direction: rtl; text-align: right; margin-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);">
                <div class="card-header bg-dark text-warning fw-bold text-center">فرم ثبت‌نام</div>
                <div class="card-body" style="background: rgba(0, 0, 0, 0.5); color: #d1d1d1;">
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label text-warning">نام کاربری</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="نام کاربری خود را وارد کنید" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-warning">ایمیل</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-warning">رمز عبور</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="رمز عبور خود را وارد کنید" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">ثبت‌نام</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php" class="text-white">قبلاً ثبت‌نام کرده‌اید؟ ورود کنید</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
