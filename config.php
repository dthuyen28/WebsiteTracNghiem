<?php
// Thông số CSDL
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ten_database_cua_ban'); // <-- Sửa tên database của bạn

// Khởi tạo Kết nối
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    // Nếu lỗi kết nối, chương trình dừng lại và báo lỗi
    die("Lỗi kết nối CSDL: " . $conn->connect_error);
}

// Nếu kết nối thành công, biến $conn đã sẵn sàng để dùng trong test_db.php
?>