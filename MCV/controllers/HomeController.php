<?php
// HomeController kế thừa (extends) class controller ở trên
class HomeController extends Controller {
    
    public function index() {
        // Gọi model
        // $User = $this->model("UserModel");

        // Gọi view và truyền dữ liệu
        $this->view("user/login", [
            "tieude" => "Trang chủ Trắc nghiệm"
        ]);
    }
}
