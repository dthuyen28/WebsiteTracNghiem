<?php
require_once CORE_PATH . '/AuthMiddleware.php';
class UserController extends Controller
{
    public $userModel;

    public function __construct()
    {
        parent::__construct();

        // 1. BẢO MẬT: Chỉ Admin mới được truy cập Controller này
        AuthCore::checkPermission('admin');

        // 2. Load Model
        $this->userModel = $this->model("UserModel");
    }

    /**
     * Hiển thị danh sách người dùng (Giao diện bảng)
     */
    public function index()
    {
        // Lấy toàn bộ danh sách từ DB
        $data = $this->userModel->getAll();

        $this->view("main_layout", [
            "Page" => "admin/users/list", // Bạn cần tạo View này: views/admin/users/list.php
            "Title" => "Quản lý người dùng",
            "Data" => $data,
            "Script" => "user_manager", // File JS xử lý Ajax (nếu cần)
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1,
                "datatables" => 1, // Plugin phân trang, tìm kiếm
                "sweetalert2" => 1
            ]
        ]);
    }

    /**
     * API: Lấy thông tin 1 user để hiện lên Modal sửa
     */
    public function getDetail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $user = $this->userModel->getById($id);
            
            // Xóa mật khẩu khỏi mảng trả về để bảo mật
            unset($user['password']); 
            unset($user['token']);

            echo json_encode($user);
        }
    }

    /**
     * Xử lý Thêm mới User (Admin tạo)
     */
    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role']; // 'admin' hoặc 'student'

            // Validate cơ bản
            if (empty($username) || empty($password)) {
                echo json_encode(["status" => false, "msg" => "Vui lòng nhập đủ thông tin!"]);
                return;
            }

            // Gọi Model tạo mới
            $result = $this->userModel->create($username, $password, $fullname, $email, $role);

            if ($result === true) {
                echo json_encode(["status" => true, "msg" => "Thêm người dùng thành công!"]);
            } else {
                echo json_encode(["status" => false, "msg" => $result]); // $result chứa thông báo lỗi (vd: trùng username)
            }
        }
    }

    /**
     * Xử lý Cập nhật User
     */
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $password = $_POST['password']; // Nếu rỗng nghĩa là không đổi pass

            // Gọi Model cập nhật (Admin có quyền đổi role và reset pass)
            $result = $this->userModel->updateUserByAdmin($id, $fullname, $email, $role, $password);

            if ($result) {
                echo json_encode(["status" => true, "msg" => "Cập nhật thành công!"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Cập nhật thất bại!"]);
            }
        }
    }

    /**
     * Xử lý Xóa User
     */
    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];

            // 1. Chặn việc tự xóa chính mình
            if ($id == $_SESSION['user_id']) {
                echo json_encode(["status" => false, "msg" => "Bạn không thể xóa tài khoản đang đăng nhập!"]);
                return;
            }

            // 2. Gọi Model xóa
            $result = $this->userModel->delete($id);

            if ($result) {
                echo json_encode(["status" => true, "msg" => "Xóa thành công!"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Lỗi khi xóa người dùng này."]);
            }
        }
    }
}