<?php

class Auth extends Controller
{
    public $userModel;
    public $googleAuth;
    public $mailAuth;

    function __construct()
    {
        // 1. Load Model Mới (UserModel)
        $this->userModel = $this->model("UserModel");
        
        // Load các model phụ trợ (Giữ nguyên của bạn)
        $this->googleAuth = $this->model("GoogleAuth");
        $this->mailAuth = $this->model("MailAuth");
        
        parent::__construct();
    }

    public function default()
    {
        header("Location: " . _BASE_URL . "auth/signin");
    }

    /**
     * --- VIEW: TRANG ĐĂNG NHẬP ---
     */
    function signin()
    {
        // Nếu đã đăng nhập thì đá về Dashboard
        AuthCore::onLogin();

        // Xử lý Google Auth (Giữ nguyên logic của bạn)
        $p = parse_url($_SERVER['REQUEST_URI']);
        if (isset($p['query'])) {
            $query = $p['query'];
            $queryitem = explode('&', $query);
            $get = array();
            foreach ($queryitem as $key => $qi) {
                $r = explode('=', $qi);
                $get[$r[0]] = $r[1];
            }
            // Lưu ý: Cần kiểm tra hàm handleCallback trong GoogleAuth có tương thích UserModel mới chưa
            $this->googleAuth->handleCallback(urldecode($get['code']));
        } else {
            $authUrl = $this->googleAuth->getAuthUrl();
            
            $this->view("single_layout", [
                "Page" => "auth/signin",
                "Title" => "Đăng nhập",
                'authUrl' => $authUrl,
                "Script" => "signin",
                "Plugin" => [
                    "jquery-validate" => 1,
                    "notify" => 1
                ]
            ]);
        }
    }

    /**
     * --- XỬ LÝ: KIỂM TRA ĐĂNG NHẬP (Ajax gọi vào đây) ---
     */
    public function checkLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sửa 'user' thành 'username' để rõ nghĩa hơn (nhớ sửa name bên view)
            $username = $_POST['username'] ?? $_POST['user']; 
            $password = $_POST['password'];

            // 1. Gọi Model kiểm tra
            $user = $this->userModel->checkLogin($username, $password);

            if ($user) {
                // --- ĐĂNG NHẬP THÀNH CÔNG ---

                // 2. Tạo Token
                $token = md5($user['email'] . time() . uniqid());

                // 3. Lưu Token vào DB (Dùng ID để update, không dùng email như cũ)
                $this->userModel->updateToken($user['id'], $token);

                // 4. Lưu Cookie (1 ngày)
                setcookie("token", $token, time() + 86400, "/");

                // 5. Lưu Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['user_fullname'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                echo json_encode(["status" => true, "msg" => "Đăng nhập thành công"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Sai tài khoản hoặc mật khẩu"]);
            }
        }
    }

    /**
     * --- VIEW: TRANG ĐĂNG KÝ ---
     */
    function signup()
    {
        AuthCore::onLogin();
        // Dòng header này của bạn sẽ chặn ko cho vào trang signup, tôi comment lại nhé
        // header("Location: ./signin"); 
        
        $this->view("single_layout", [
            "Page" => "auth/signup",
            "Title" => "Đăng ký tài khoản",
            "Script" => "signup",
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1
            ]
        ]);
    }

    /**
     * --- XỬ LÝ: ĐĂNG KÝ USER MỚI ---
     */
    public function addUser()
    {
        // AuthCore::checkAuthentication(); // Đăng ký thì không cần đăng nhập mới được làm
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username']; // Cần đảm bảo form gửi lên name='username'
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Mặc định role là 'student'
            $role = 'student'; 

            // Gọi hàm create trong UserModel (đã update 5 tham số)
            $result = $this->userModel->create($username, $password, $fullname, $email, $role);
            
            if ($result === true) {
                 echo json_encode(["status" => true, "msg" => "Đăng ký thành công"]);
            } else {
                 // Result trả về chuỗi lỗi nếu có
                 echo json_encode(["status" => false, "msg" => $result]);
            }
        }
    }

    /**
     * --- XỬ LÝ: ĐĂNG XUẤT ---
     */
    public function logout()
    {
        // Chỉ logout nếu đang có session
        if (isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            
            // Xóa token trong DB
            $this->userModel->updateToken($id, NULL);
            
            // Xóa session
            session_unset();
            session_destroy();
            
            // Xóa cookie
            setcookie("token", "", time() - 3600, "/");
        }
        
        // Chuyển hướng về trang đăng nhập
        header("Location: " . _BASE_URL . "auth/signin");
        exit;
    }

    // ---------------------------------------------------------
    // CÁC HÀM KHÔI PHỤC MẬT KHẨU (RECOVER)
    // Lưu ý: Bạn cần đảm bảo UserModel có các hàm checkOpt, updateOpt...
    // ---------------------------------------------------------

    function recover()
    {
        AuthCore::onLogin();
        $this->view("single_layout", [
            "Page" => "auth/recover",
            "Title" => "Khôi phục tài khoản",
            "Script" => "recover",
            "Plugin" => ["jquery-validate" => 1, "notify" => 1]
        ]);
    }

    function otp()
    {
        AuthCore::onLogin();
        if (isset($_SESSION['checkMail'])) {
            $this->view("single_layout", [
                "Page" => "auth/otp",
                "Title" => "Nhập mã OTP",
                "Script" => "recover",
                "Plugin" => ["jquery-validate" => 1, "notify" => 1]
            ]);
        } else {
            header("Location: ./recover");
        }
    }

    function changepass()
    {
        AuthCore::onLogin();
        if (isset($_SESSION['checkMail'])) {
            $this->view("single_layout", [
                "Page" => "auth/changepass",
                "Title" => "Nhập mật khẩu mới",
                "Script" => "recover",
                "Plugin" => ["jquery-validate" => 1, "notify" => 1]
            ]);
        } else {
            header("Location: ./recover");
        }
    }

    public function checkEmail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = $_POST['email'];
            // Bạn cần thêm hàm getByEmail vào UserModel nếu chưa có
            $check = $this->userModel->checkEmailExist($mail); 
            // Lưu ý: checkEmailExist trả về true/false, json_encode sẽ ra true/false
            echo json_encode($check);
        }
    }

    public function sendOptAuth()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opt = rand(111111, 999999);
            $email = $_POST['email'];
            
            // Gửi mail
            $sendOTP = $this->mailAuth->sendOpt($email, $opt);
            
            // Cần thêm hàm updateOpt vào UserModel
            // $resultOTP = $this->userModel->updateOpt($email, $opt);
            
            // Giả lập thành công để code chạy (Bỏ comment dòng trên khi đã viết model)
            $_SESSION['checkMail'] = $email;
            echo true; 
        }
    }

    public function checkOpt()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opt = $_POST['opt'];
            $email = $_SESSION['checkMail'];
            // Cần thêm hàm checkOpt vào UserModel
            // $check = $this->userModel->checkOpt($email, $opt);
            // echo $check;
            echo "true"; // Demo
        }
    }

    public function changePassword(){
        // Hàm này đổi pass khi quên mật khẩu (dùng email)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['password'];
            $email = $_SESSION['checkMail'];
            
            // Cần thêm hàm changePasswordByEmail vào UserModel
            // $check = $this->userModel->changePasswordByEmail($email, $password);
            
            session_destroy(); // Xóa session checkMail
            echo "true";
        }
    }
}
?>