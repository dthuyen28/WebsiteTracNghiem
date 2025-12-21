<?php

class App
{
    // Controller mặc định khi vào trang chủ (không có url)
    protected $controller = "HomeController";
    
    // Method mặc định
    protected $method = "index";
    
    // Tham số trên URL
    protected $params = [];

    public function __construct()
    {
        // 1. Phân tích URL
        $url = $this->parseUrl();

        // 2. Xử lý CONTROLLER
        if (!empty($url[0])) {
            // Quy tắc: Tên URL viết hoa chữ đầu + "Controller"
            // Ví dụ: user gõ "/auth" -> Tìm file "AuthController.php"
            $controllerName = ucfirst($url[0]) . "Controller";
            
            // Kiểm tra file có tồn tại trong thư mục controllers không
            // (Sử dụng CONTROLLER_PATH đã định nghĩa trong config.php)
            if (file_exists(CONTROLLER_PATH . "/" . $controllerName . ".php")) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Nạp file controller
        require_once CONTROLLER_PATH . "/" . $this->controller . ".php";
        
        // Khởi tạo Class Controller
        $this->controller = new $this->controller;

        // 3. Xử lý METHOD (Hàm)
        if (!empty($url[1])) {
            // Kiểm tra xem trong class controller đó có hàm này không
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 4. Xử lý PARAMS (Tham số còn lại)
        $this->params = $url ? array_values($url) : [];

        // 5. GỌI HÀM THỰC THI
        // call_user_func_array([TênClass, TênHàm], [MảngThamSố])
        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );
    }

    // Hàm tách URL thành mảng
    public function parseUrl()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(
                rtrim($_GET["url"], "/"),
                FILTER_SANITIZE_URL
            ));
        }
        return [];
    }
}