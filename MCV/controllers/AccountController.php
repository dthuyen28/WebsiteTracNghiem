<?php

class AccountController extends Controller
{
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        // 1. Kiểm tra đăng nhập (Bắt buộc)
        AuthCore::checkAuthentication();
        
        // 2. Load Model
        $this->userModel = $this->model("UserModel");
    }

    // Trang mặc định: Thông tin cá nhân
    function index()
    {
        // Lấy thông tin user hiện tại từ Session
        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->getById($userId);

        $this->view("main_layout", [
            "Page" => "account/profile", // Bạn cần tạo view này
            "Title" => "Trang cá nhân",
            "User" => $user,
            "Plugin" => [
                "sweetalert2" => 1,
                "jquery-validate" => 1,
                "notify" => 1,
            ],
            "Script" => "account_setting" // File JS xử lý ajax
        ]);
    }

    // Đổi mật khẩu
    public function changepassword()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $current_pass = $_POST['matkhaucu'];
            $new_pass = $_POST['matkhaumoi'];
            $id = $_SESSION['user']['id'];

            // 1. Lấy thông tin user để check pass cũ
            $user = $this->userModel->getById($id);

            // 2. Kiểm tra pass cũ có đúng không
            if (password_verify($current_pass, $user['password'])) {
                // 3. Cập nhật pass mới
                $result = $this->userModel->changePassword($id, $new_pass);
                
                if ($result) {
                    echo json_encode(["valid" => true, "message" => "Đổi mật khẩu thành công!"]);
                } else {
                    echo json_encode(["valid" => false, "message" => "Lỗi hệ thống, vui lòng thử lại."]);
                }
            } else {
                echo json_encode(["valid" => false, "message" => "Mật khẩu hiện tại không đúng."]);
            }
        }
    }

    // Cập nhật thông tin hồ sơ (Chỉ còn Fullname và Email)
    public function updateProfile()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_SESSION['user']['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];

            // Lấy email hiện tại trong session để so sánh
            $currentEmail = $_SESSION['user']['email'];

            // Nếu user đổi email mới -> Cần check xem email mới có bị trùng với người khác không
            if ($email !== $currentEmail) {
                if ($this->userModel->checkEmailExist($email)) {
                    echo json_encode(["valid" => false, "message" => "Email này đã được sử dụng bởi tài khoản khác!"]);
                    return;
                }
            }

            // Gọi hàm update (Cần thêm hàm này vào UserModel)
            $result = $this->userModel->updateProfile($id, $fullname, $email);

            if ($result) {
                // Cập nhật lại Session
                $_SESSION['user_fullname'] = $fullname;
                $_SESSION['user_email'] = $email;
                
                echo json_encode(["valid" => true, "message" => "Cập nhật hồ sơ thành công!"]);
            } else {
                echo json_encode(["valid" => false, "message" => "Không có thay đổi nào hoặc lỗi hệ thống."]);
            }
        }
    }

     // Chức năng Upload Avatar
    // LƯU Ý: Bảng 'users' trong file SQL hiện tại chưa có cột 'avatar'.
    // Bạn cần chạy lệnh SQL: ALTER TABLE users ADD avatar VARCHAR(255) NULL; để mở lại code này.
    
    public function uploadFile()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES['file-img']['name'])) {
                $id = $_SESSION['user_id'];
                $imageName = $_FILES['file-img']['name'];
                $tmpName = $_FILES['file-img']['tmp_name'];

                $validExtensions = ['jpg', 'jpeg', 'png'];
                $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                if (in_array($extension, $validExtensions)) {
                    // Xử lý upload và gọi Model
                    // $result = $this->userModel->updateAvatar($id, ...);
                    // echo json_encode($result);
                }
            }
        }
    }
    
}