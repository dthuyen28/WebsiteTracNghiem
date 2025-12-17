<?php
// gọi controller của SV3
require_once "./mvc/core/controllers/ExamController.php";

// chạy trực tiếp controller (KHÔNG routing)
$controller = new ExamController();

// nếu có tham số action thì gọi, không có thì mặc định index
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Action not found";
}
