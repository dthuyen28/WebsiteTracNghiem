<?php

class app
{
    protected $controller = "HomeController"; // Tên mặc định chính xác
    protected $action = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // 1. Kiểm tra Controller
        if (isset($url[0])) {
            if (file_exists(CONTROLLER_PATH . "/" . $url[0] . "Controller.php")) {
                $this->controller = $url[0] . "Controller";
                unset($url[0]);
            } else {
                // Nếu người dùng nhập bậy trên URL, vẫn trả về mặc định
                $this->controller = "HomeController"; 
            }
        }

        // 2. Nạp file Controller (Dòng 22 của bạn)
        $fileName = CONTROLLER_PATH . "/" . $this->controller . ".php";
        if (file_exists($fileName)) {
            require_once $fileName;
        } else {
            die("Lỗi: Không tìm thấy file controller tại " . $fileName);
        }

        // 3. Khởi tạo Class
        $this->controller = new $this->controller;

        // 4. Kiểm tra Action (Phương thức)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
                unset($url[1]);
            }
        }

        // 5. Tham số còn lại
        $this->params = $url ? array_values($url) : [];

        // 6. Chạy hàm
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    protected function parseUrl()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }
}