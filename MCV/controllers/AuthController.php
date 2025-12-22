<?php

class AuthController extends Controller
{
    public $userModel;
    public $mailModel;
    // public $googleAuth; // Nếu chưa có file GoogleAuth thì comment lại
    // public $mailAuth;   // Nếu chưa có file MailAuth thì comment lại

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model("UserModel");
        // $this->googleAuth = $this->model("GoogleAuth");
        $this->mailModel = $this->model("MailModel");
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
/**
     * --- CÁC HÀM XỬ LÝ QUÊN MẬT KHẨU ---
     */

    // 1. View: Trang nhập Email
    public function recover()
    {
        AuthCore::onLogin();
        $this->view("single_layout", [
            "Page" => "auth/recover",
            "Title" => "Khôi phục tài khoản",
            "Script" => "recover", // File JS chúng ta sẽ tạo ở dưới
            "Plugin" => ["jquery-validate" => 1, "notify" => 1]
        ]);
    }

    // 2. Xử lý: Gửi OTP (Ajax gọi vào đây)
    public function sendOtp()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');
            $email = $_POST['email'];

            // Kiểm tra email có tồn tại trong DB không
            if (!$this->userModel->checkEmailExist($email)) {
                echo json_encode(["status" => false, "msg" => "Email này chưa được đăng ký!"]);
                exit;
            }

            // Tạo OTP ngẫu nhiên 6 số
            $otp = rand(111111, 999999);

            // Gửi mail (Hàm này trong MailModel sẽ gọi PHPMailer)
            $send = $this->mailModel->sendOpt($email, $otp);

            if ($send) {
                // Lưu OTP vào DB
                $this->userModel->updateOpt($email, $otp);
                
                // Lưu email vào Session để dùng cho bước sau
                $_SESSION['checkMail'] = $email;
                
                echo json_encode(["status" => true, "msg" => "Đã gửi mã OTP. Vui lòng kiểm tra email!"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Lỗi gửi mail hệ thống. Vui lòng thử lại sau."]);
            }
            exit;
        }
    }

    // 3. View: Trang nhập mã OTP
    public function otp()
    {
        AuthCore::onLogin();
        // Nếu chưa nhập email ở bước 1 thì đá về lại bước 1
        if (!isset($_SESSION['checkMail'])) {
            header("Location: " . _BASE_URL . "auth/recover");
            exit;
        }
        $this->view("single_layout", [
            "Page" => "auth/otp",
            "Title" => "Nhập mã xác thực",
            "Script" => "recover",
            "Plugin" => ["jquery-validate" => 1, "notify" => 1]
        ]);
    }

    // 4. Xử lý: Kiểm tra OTP (Ajax gọi vào đây)
    public function checkOtp()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');
            $otp = $_POST['otp'];
            $email = $_SESSION['checkMail'];

            // Gọi Model kiểm tra khớp OTP
            $check = $this->userModel->checkOpt($email, $otp);

            if ($check) {
                // OTP đúng -> Đánh dấu đã verify để cho phép vào trang đổi pass
                $_SESSION['otp_verified'] = true;
                echo json_encode(["status" => true, "msg" => "Xác thực thành công!"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Mã OTP không đúng!"]);
            }
            exit;
        }
    }

    // 5. View: Trang đặt mật khẩu mới
    public function changepass()
    {
        AuthCore::onLogin();
        // Phải verify OTP xong mới được vào đây
        if (!isset($_SESSION['checkMail']) || !isset($_SESSION['otp_verified'])) {
            header("Location: " . _BASE_URL . "auth/recover");
            exit;
        }

        $this->view("single_layout", [
            "Page" => "auth/changepass",
            "Title" => "Đặt lại mật khẩu",
            "Script" => "recover",
            "Plugin" => ["jquery-validate" => 1, "notify" => 1]
        ]);
    }

    // 6. Xử lý: Đổi mật khẩu mới (Ajax gọi vào đây)
    public function handleChangepass()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $email = $_SESSION['checkMail'];

            if ($password !== $repassword) {
                echo json_encode(["status" => false, "msg" => "Mật khẩu nhập lại không khớp!"]);
                exit;
            }

            // Gọi Model cập nhật pass mới (hàm này cũng xóa luôn OTP cũ trong DB)
            $this->userModel->changePasswordByEmail($email, $password);

            // Xóa sạch session tạm để hoàn tất quy trình
            unset($_SESSION['checkMail']);
            unset($_SESSION['otp_verified']);

            echo json_encode(["status" => true, "msg" => "Đổi mật khẩu thành công!"]);
            exit;
        }
    }

}