<?php include 'header.php'; ?>
<!-- Header -->
<header class="rtl custom-header" style="direction: rtl; text-align: center;">
    <div class="container">
        <h1 style="color: #fff;">محاسبه متابولیسم پایه (BMR) و نیاز کالری روزانه</h1>
        <p class="lead" style="color: #e0e0e0;">با وارد کردن اطلاعات خود، متابولیسم پایه و کالری روزانه مورد نیاز خود را محاسبه کنید.</p>
    </div>
</header>

<div class="container content-section" style="direction: rtl; text-align: right;">
    <!-- فرم ورودی BMR -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                    <h4>ورود اطلاعات برای محاسبه BMR</h4>
                </div>
                <div class="card-body">
                    <form id="bmrForm">
                        <div class="mb-3">
                            <label for="weight" class="form-label" style="color: #e0e0e0;">وزن (کیلوگرم):</label>
                            <input type="number" class="form-control" id="weight" name="weight" placeholder="وزن خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="mb-3">
                            <label for="height" class="form-label" style="color: #e0e0e0;">قد (سانتی‌متر):</label>
                            <input type="number" class="form-control" id="height" name="height" placeholder="قد خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label" style="color: #e0e0e0;">سن (سال):</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="سن خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label" style="color: #e0e0e0;">جنسیت:</label>
                            <select class="form-control" id="gender" name="gender" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                                <option value="male">مرد</option>
                                <option value="female">زن</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="activityLevel" class="form-label" style="color: #e0e0e0;">سطح فعالیت:</label>
                            <select class="form-control" id="activityLevel" name="activityLevel" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                                <option value="1.2">خیلی کم تحرک (بدون ورزش)</option>
                                <option value="1.375">کم تحرک (ورزش سبک 1-3 روز در هفته)</option>
                                <option value="1.55">فعال متوسط (ورزش متوسط 3-5 روز در هفته)</option>
                                <option value="1.725">خیلی فعال (ورزش شدید 6-7 روز در هفته)</option>
                                <option value="1.9">بسیار فعال (ورزش شدید یا کار فیزیکی)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background: #007bff; border: none; font-size: 16px;">محاسبه</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- نمایش نتیجه BMR -->
    <div id="resultSection" class="row justify-content-center mt-4" style="display: none;">
        <div class="col-md-8">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #ffd700;">
                    <h4>نتیجه محاسبه BMR و TDEE</h4>
                </div>
                <div class="card-body text-center">
                    <p id="bmrResult" style="color: #fff; font-size: 18px;">متابولیسم پایه شما (BMR): <strong></strong></p>
                    <p id="tdeeResult" style="color: #fff; font-size: 18px;">نیاز کالری روزانه شما (TDEE): <strong></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('bmrForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // دریافت مقادیر ورودی
        var weight = parseFloat(document.getElementById('weight').value);
        var heightCm = parseFloat(document.getElementById('height').value);
        var age = parseInt(document.getElementById('age').value);
        var gender = document.getElementById('gender').value;
        var activityLevel = parseFloat(document.getElementById('activityLevel').value);

        // بررسی مقادیر ورودی
        if (isNaN(weight) || isNaN(heightCm) || isNaN(age) || weight <= 0 || heightCm <= 0 || age <= 0) {
            alert('لطفاً مقادیر صحیح برای وزن، قد و سن وارد کنید!');
            return;
        }

        // محاسبه BMR بر اساس جنسیت
        var bmr;
        if (gender === "male") {
            bmr = 88.36 + (13.4 * weight) + (4.8 * heightCm) - (5.7 * age);
        } else if (gender === "female") {
            bmr = 447.6 + (9.2 * weight) + (3.1 * heightCm) - (4.3 * age);
        }

        // محاسبه TDEE
        var tdee = bmr * activityLevel;

        // گرد کردن نتایج
        bmr = bmr.toFixed(2);
        tdee = tdee.toFixed(2);

        // نمایش نتایج
        document.getElementById('bmrResult').innerHTML = 'متابولیسم پایه شما (BMR): <strong>' + bmr + ' کالری</strong>';
        document.getElementById('tdeeResult').innerHTML = 'نیاز کالری روزانه شما (TDEE): <strong>' + tdee + ' کالری</strong>';
        document.getElementById('resultSection').style.display = 'block';
    });
</script>

<?php include 'footer.php'; ?>
