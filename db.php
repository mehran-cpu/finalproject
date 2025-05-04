<?php
$servername = "localhost";
$username = "root"; // نام کاربری پیش‌فرض در Wamp
$password = ""; // معمولاً در Wamp بدون پسورد است
$database = "gymhubdatabase"; // نام دیتابیسی که ساخته‌اید

$conn = new mysqli($servername, $username, $password, $database);

// بررسی اتصال
if ($conn->connect_error) {
    die("اتصال به دیتابیس ناموفق بود: " . $conn->connect_error);
}

?>
