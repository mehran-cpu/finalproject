<?php include 'header.php'; ?>
<!-- Header -->
<header class="rtl custom-header" style="direction: rtl; text-align: center;">
    <div class="container">
        <h1 style="color: #fff;">محاسبه شاخص توده بدنی (BMI)</h1>
        <p class="lead" style="color: #e0e0e0;">با وارد کردن وزن و قد خود، شاخص توده بدنی (BMI) خود را محاسبه کنید</p>
    </div>
</header>

<div class="container content-section" style="direction: rtl; text-align: right;">
    <!-- فرم ورودی BMI -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                    <h4>ورود اطلاعات برای محاسبه BMI</h4>
                </div>
                <div class="card-body">
                    <form id="bmiForm">
                        <div class="mb-3">
                            <label for="weight" class="form-label" style="color: #e0e0e0;">وزن (کیلوگرم):</label>
                            <input type="number" class="form-control" id="weight" name="weight" placeholder="وزن خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <div class="mb-3">
                            <label for="height" class="form-label" style="color: #e0e0e0;">قد (سانتی‌متر):</label>
                            <input type="number" class="form-control" id="height" name="height" placeholder="قد خود را وارد کنید" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background: #007bff; border: none; font-size: 16px;">محاسبه</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- نمایش نتیجه BMI -->
    <div id="resultSection" class="row justify-content-center mt-4" style="display: none;">
        <div class="col-md-6">
            <div class="card" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header text-center" style="background: rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: #ffd700;">
                    <h4>نتیجه محاسبه BMI</h4>
                </div>
                <div class="card-body text-center">
                    <p id="bmiResult" style="color: #fff; font-size: 18px;">شاخص توده بدنی شما: <strong></strong></p>
                    <p id="bmiCategory" style="color: #ffd700; font-size: 18px;">دسته‌بندی BMI شما: <strong></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('bmiForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // دریافت مقادیر ورودی
        var weight = parseFloat(document.getElementById('weight').value);
        var heightCm = parseFloat(document.getElementById('height').value);

        // تبدیل قد به متر
        var heightM = heightCm / 100;
        
        // چک کردن مقادیر ورودی
        if (isNaN(weight) || isNaN(heightM) || weight <= 0 || heightM <= 0) {
            alert('لطفاً مقادیر صحیح برای وزن و قد وارد کنید!');
            return;
        }

        // محاسبه BMI
        var bmi = weight / Math.pow(heightM, 2); // فرمول صحیح BMI با استفاده از Math.pow برای قد به توان 2
        bmi = bmi.toFixed(2); // گرد کردن نتیجه به دو رقم اعشار
        
        // تعیین دسته‌بندی BMI
        var category = '';
        if (bmi < 18.5) {
            category = "کم‌وزن";
        } else if (bmi >= 18.5 && bmi < 24.9) {
            category = "وزن طبیعی";
        } else if (bmi >= 25 && bmi < 29.9) {
            category = "اضافه وزن";
        } else {
            category = "چاق";
        }
        
        // نمایش نتیجه
        document.getElementById('bmiResult').innerHTML = 'شاخص توده بدنی شما: <strong>' + bmi + '</strong>';
        document.getElementById('bmiCategory').innerHTML = 'دسته‌بندی BMI شما: <strong>' + category + '</strong>';
        document.getElementById('resultSection').style.display = 'block';
    });
</script>

<?php include 'footer.php'; ?>
