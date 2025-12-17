<?php

// 1. Định nghĩa đường dẫn gốc của ứng dụng (BASE_DIR)
// Giúp dễ dàng require/include các file sau này
define('BASE_DIR', dirname(__DIR__)); 

// 2. Tải lớp kết nối CSDL và các thành phần cốt lõi (Core components)
require_once BASE_DIR . '/MCV/core/Database.php';

// 3. Phân tích URL (Routing cơ bản)
// Lấy đường dẫn yêu cầu (ví dụ: /questions/index)
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Loại bỏ thư mục gốc (nếu bạn chạy từ localhost/Tracnghiem/)
$base_path = 'Tracnghiem/WebsiteTracNghiem/public'; // Hoặc bỏ qua dòng này nếu dùng .htaccess // THAY ĐỔI THEO THƯ MỤC CỦA BẠN TRÊN HOST
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Tách Controller, Action và các tham số
$segments = explode('/', trim($request_uri, '/'));

// Lấy Controller và Action (hàm)
$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
$actionName = !empty($segments[1]) ? $segments[1] : 'index';

// 4. Khởi động Controller
$controllerFile = BASE_DIR . '/MCV/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    if (method_exists($controller, $actionName)) {
        // Gọi phương thức (hàm) của Controller
        $controller->$actionName();
    } else {
        // Xử lý lỗi 404 cho Action
        echo "404 Not Found: Action '{$actionName}' không tồn tại trong Controller.";
    }
} else {
    // Xử lý lỗi 404 cho Controller
    echo "404 Not Found: Controller '{$controllerName}' không tồn tại.";
}