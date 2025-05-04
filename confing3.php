<?php
$host = "localhost"; // هاست دیتابیس در WAMP
$dbname = "gymhubdatabase"; // نام صحیح دیتابیس شما
$username = "root"; // نام کاربری پیش‌فرض WAMP
$password = ""; // رمز عبور خالی برای WAMP

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ خطا در اتصال به دیتابیس: " . $e->getMessage());
}
?>
