<?php
requireRole('admin');
class AdminController extends Controller
{
    // Khai báo các biến Model sẽ dùng
    public $userModel;
    public $questionModel;
    public $examModel;

    public function __construct()
    {
        // 1. Chạy constructor của cha để khởi tạo DB
        parent::__construct();

        // 2. Lớp bảo vệ: Chỉ cho phép ADMIN truy cập
        // Nếu là student hoặc chưa đăng nhập -> sẽ bị đá ra ngoài bởi AuthCore
        AuthCore::checkPermission('admin');

        // 3. Load các Model cần thiết
        $this->userModel = $this->model("UserModel");
        
        // (Lưu ý: Bạn cần tạo file QuestionModel.php và ExamModel.php tương tự UserModel)
        // $this->questionModel = $this->model("QuestionModel");
        // $this->examModel = $this->model("ExamModel");
    }

    /**
     * Trang Dashboard (Mặc định)
     */
    public function index()
    {
        // Lấy số liệu thống kê (Giả sử Model có hàm đếm)
        // $countUsers = $this->userModel->countAll(); 
        
        $this->view("main_layout", [
            "Page" => "admin/dashboard", // View con nằm trong views/admin/dashboard.php
            "Title" => "Trang quản trị",
            "Script" => "admin_dashboard", // File JS riêng nếu cần
            "Plugin" => [
                "chartjs" => 1, // Ví dụ plugin biểu đồ
                "notify" => 1
            ]
        ]);
    }

    /**
     * --- QUẢN LÝ NGƯỜI DÙNG ---
     */

    // Hiển thị danh sách người dùng
    public function users()
    {
        // Gọi hàm getAll trong UserModel (Bạn cần viết thêm hàm này vào Model)
        // Lưu ý: Cần viết hàm getAll() trong UserModel trả về SELECT * FROM users
        $danhsachUser = $this->userModel->getAll(); 

        $this->view("main_layout", [
            "Page" => "admin/users/list", // View hiển thị bảng user
            "Title" => "Quản lý người dùng",
            "Data" => $danhsachUser,
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1,
                "datatables" => 1 // Plugin bảng dữ liệu
            ]
        ]);
    }

    // Xử lý thêm người dùng (Ajax POST)
    public function createUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role']; // 'admin' hoặc 'student'

            // Gọi hàm create đã viết trong UserModel
            $result = $this->userModel->create($username, $password, $fullname, $email, $role);

            if ($result === true) {
                echo json_encode(["status" => true, "msg" => "Thêm người dùng thành công!"]);
            } else {
                // Nếu lỗi (ví dụ trùng username)
                echo json_encode(["status" => false, "msg" => $result]); // $result trả về chuỗi lỗi
            }
        }
    }

    // Xóa người dùng
    public function deleteUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            
            // Không cho phép xóa chính mình
            if ($id == $_SESSION['user']['id']) {
                echo json_encode(["status" => false, "msg" => "Không thể tự xóa tài khoản đang đăng nhập!"]);
                return;
            }

            // Gọi hàm delete (Cần bổ sung vào UserModel)
            $result = $this->userModel->delete($id);
            
            if ($result) {
                echo json_encode(["status" => true, "msg" => "Xóa thành công!"]);
            } else {
                echo json_encode(["status" => false, "msg" => "Xóa thất bại!"]);
            }
        }
    }

    /**
     * --- QUẢN LÝ MÔN HỌC / CÂU HỎI (Ví dụ khung) ---
     */
    public function questions()
    {
        $this->view("main_layout", [
            "Page" => "admin/questions/list",
            "Title" => "Ngân hàng câu hỏi",
            // "Data" => $this->questionModel->getAll()
        ]);
    }
}
?>