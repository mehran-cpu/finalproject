<?php include 'header.php'; ?>
<!-- Header -->
<header class="rtl custom-header contact-header" style="direction: rtl; text-align: center; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); color: #fff;">
    <div class="container">
        <h1>تماس با ما</h1>
        <p class="lead" style="color: #e0e0e0;">ما همیشه آماده پاسخگویی به سوالات و درخواست‌های شما هستیم.</p>
    </div>
</header>

<div class="container content-section contact-content" style="direction: rtl; text-align: right;">
    <!-- اطلاعات تماس -->
    <div class="row contact-info">
        <div class="col-md-6 mb-4">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                    <h4>اطلاعات تماس</h4>
                </div>
                <div class="card-body" style="color: #e0e0e0;">
                    <p><strong>آدرس:</strong> تهران، خیابان آزادی، پلاک 12</p>
                    <p><strong>تلفن 1:</strong> 09941333816</p>
                    <p><strong>تلفن 2:</strong> 09012949710</p>
                    <p><strong>ایمیل:</strong> gymhub@gmail.com</p>
                    <p><strong>ساعات کاری:</strong> شنبه تا پنج‌شنبه - 9:00 صبح تا 6:00 عصر</p>
                </div>
            </div>
        </div>
        
        <!-- فرم تماس -->
        <div class="col-md-6 mb-4">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                    <h4>فرم تماس با ما</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group mb-3">
                            <label for="name" style="color: #e0e0e0;">نام و نام خانوادگی</label>
                            <input type="text" class="form-control" id="name" placeholder="نام خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" style="color: #e0e0e0;">ایمیل</label>
                            <input type="email" class="form-control" id="email" placeholder="ایمیل خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" style="color: #e0e0e0;">پیام</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="پیام خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background: #007bff; border: none; font-size: 16px;">ارسال پیام</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Add AOS (Animate On Scroll) JavaScript for animations -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS for scroll animations
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        offset: 200
    });

    // Optional: Smooth scroll on button click
    document.querySelectorAll('.btn-primary').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            alert('پیام شما ارسال شد!');
        });
    });
</script>
