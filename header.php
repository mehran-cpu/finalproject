<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymHub</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-size: cover;
        color: #fff;
    }

    .navbar {
        background: rgba(0, 0, 0, 0.6);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transition: background 0.3s ease-in-out;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar, .navbar .navbar-brand, .navbar .nav-link, .navbar .dropdown-item {
        color: #fff !important;
    }

    .navbar:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .dropdown-menu {
        background: rgba(0, 0, 0, 0.9) !important;
        border: none;
    }

    .dropdown-item:hover {
        color: #FFD700;
        background: rgba(255, 255, 255, 0.1);
    }
</style>
<body dir="rtl" class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">GymHub</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">خانه</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="management.php">مدیریت</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white px-3 py-1" href="logout.php">خروج</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">ورود</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">ثبت‌نام</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="supplementsDropdown" data-toggle="dropdown">مکمل‌ها</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="protein.php">پروتئین‌ها</a></li>
                        <li><a class="dropdown-item" href="vitamins.php">ویتامین‌ها</a></li>
                        <li><a class="dropdown-item" href="energyBoosters.php">افزایش‌دهنده‌های انرژی</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="clothesDropdown" data-toggle="dropdown">لباس‌ها</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="sportswear.php">لباس‌های ورزشی</a></li>
                        <li><a class="dropdown-item" href="shoes.php">کفش‌ها</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="equipmentDropdown" data-toggle="dropdown">لوازم ورزشی</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="weights.php">وزنه‌ها</a></li>
                        <li><a class="dropdown-item" href="machines.php">دستگاه‌های بدنسازی</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="calculationsDropdown" data-toggle="dropdown">محاسبات</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="metabolism.php">محاسبه متابولیسم</a></li>
                        <li><a class="dropdown-item" href="bmi.php"> BMIمحاسبه</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="supplements-store.php">خرید مکمل</a>
                </li>
                <li>
                <a href="cart.php" class="nav-link">🛒 مشاهده سبد خرید</a>

                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">تماس با ما</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    window.onscroll = function() { changeNavbarColor(); };
    function changeNavbarColor() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
</script>
<script src="bootstrap.js"></script>
</body>
</html>
