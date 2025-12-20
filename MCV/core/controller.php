<?php

class Controller {

    public function __construct() {
        // Chỉ đảm bảo Session đã được bật để các Controller con sử dụng
        // Tuyệt đối KHÔNG redirect ở đây để tránh lỗi Loop
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Load model
    public function model($model) {
        // Kiểm tra file có tồn tại không để báo lỗi dễ debug
        $file = MODEL_PATH . "/" . $model . ".php";
        
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        } else {
            die("Không tìm thấy Model: " . $model);
        }
    }

    // Load view
    public function view($view, $data = []) {
        // Giải nén mảng data thành các biến riêng lẻ
        // Ví dụ: ["Title" => "Trang chủ"] sẽ thành biến $Title
        if (!empty($data)) {
            extract($data);
        }

        $file = VIEW_PATH . "/" . $view . ".php";

        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Không tìm thấy View: " . $view); // Báo lỗi nếu quên tạo file view
        }
    }
}