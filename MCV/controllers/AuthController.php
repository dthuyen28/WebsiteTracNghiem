<?php

class AuthController extends Controller
{
    public $userModel;
    // public $googleAuth; // Nếu chưa có file GoogleAuth thì comment lại
    // public $mailAuth;   // Nếu chưa có file MailAuth thì comment lại

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model("UserModel");
        // $this->googleAuth = $this->model("GoogleAuth");
        // $this->mailAuth = $this->model("MailAuth");
    }

    public function index()
    {
        header("Location: " . _BASE_URL . "auth/signin");
    }
    private function setUserSession($user)
{
    $_SESSION['user'] = [
        'id'       => $user['id'],
        'username' => $user['username'],
        'fullname' => $user['fullname'],
        'email'    => $user['email'],
        'role'     => $user['role']
    ];
}


    /**
     * --- ĐĂNG NHẬP (Xử lý Ajax) ---
     */
    public function signin()
    {      
        // 1. Xử lý khi Ajax gửi dữ liệu POST lên
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->checkLogin($username, $password);

            if ($user) {
                // Tạo Token
                $token = md5($user['email'] . time() . uniqid());
                
                // Lưu Token vào DB
                $this->userModel->updateToken($user['id'], $token);
                
                // Lưu Cookie (1 ngày)
                setcookie("token", $token, time() + 86400, "/");

                // Lưu Session      
                $this->setUserSession($user);

                echo json_encode(["status" => true, "msg" => "Đăng nhập thành công! Đang chuyển hướng..."], JSON_UNESCAPED_UNICODE );
            } else {
                echo json_encode(["status" => false, "msg" => "Sai tài khoản hoặc mật khẩu!"], JSON_UNESCAPED_UNICODE);
            }
            exit; // Dừng code PHP tại đây để trả về JSON sạch
        }
        AuthCore::onLogin();
        
        // 2. Hiển thị View (GET)
        $this->view("single_layout", [
            "Page" => "auth/signin",
            "Title" => "Đăng nhập hệ thống",
            "Script" => "signin", // Tự động load public/js/signin.js
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1
            ]
        ]);
    }

    /**
     * --- ĐĂNG KÝ (Xử lý Ajax) ---
     */
    public function signup()
    {
        AuthCore::onLogin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];

            // Kiểm tra mật khẩu khớp
            if ($password !== $repassword) {
                echo json_encode(["status" => false, "msg" => "Mật khẩu nhập lại không khớp!"]);
                exit;
            }

            // Gọi Model tạo user (Mặc định role 'student')
            $result = $this->userModel->create($username, $password, $fullname, $email, 'student');

            if ($result === true) {
                echo json_encode(["status" => true, "msg" => "Đăng ký thành công! Vui lòng đăng nhập."], JSON_UNESCAPED_UNICODE);
            }
            exit;
        }

        $this->view("single_layout", [
            "Page" => "auth/signup",
            "Title" => "Đăng ký tài khoản",
            "Script" => "signup", // Tự động load public/js/signup.js
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1
            ]
        ]);
    }

    /**
     * --- ĐĂNG XUẤT ---
     */
    public function logout()
{
    // Xóa session
    session_unset();
    session_destroy();

    // Xóa cookie remember / token
    if (isset($_COOKIE['token'])) {
        setcookie('token', '', time() - 3600, '/');
    }

    // Chuyển về trang đăng nhập
    header("Location: " . _BASE_URL . "/auth/signin");
    exit;
}

}