<?php

class TestController extends Controller {

    public function index() {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        if ($pdo) {
            echo "Kết nối Database (Singleton) thành công!";
        }
    }
}
