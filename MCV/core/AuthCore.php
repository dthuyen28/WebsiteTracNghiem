<?php
// Nạp Model mới (UserModel) thay vì NguoiDungModel cũ
require_once "./MCV/models/UserModel.php";

class AuthCore
{
    /**
     * Hàm này đặt ở trang Đăng nhập/Đăng ký.
     * Tác dụng: Nếu đã đăng nhập rồi (có token hợp lệ) -> Đá về trang chủ ngay.
     * Tránh trường hợp user đã login mà vẫn vào lại được trang đăng nhập.
     */
    public static function onLogin()
    {
        if (isset($_COOKIE['token'])) {
            $userModel = new UserModel();
            $token = $_COOKIE['token'];
            
            // Kiểm tra token có khớp trong DB không
            if ($userModel->validateToken($token) == true) {
                // Nếu đúng -> Chuyển hướng về trang chủ
                header("Location: " . _BASE_URL . "home/index");
                exit();
            }
        }
    }

    /**
     * Hàm này đặt ở các trang cần bảo mật (Home, Admin, Account...).
     * Tác dụng: Nếu chưa đăng nhập hoặc token giả -> Đá về trang Login.
     */
    public static function checkAuthentication()
    {
        // 1. Kiểm tra xem trình duyệt có Cookie token không
        if (!isset($_COOKIE['token'])) {
            self::redirectToLogin();
            return;
        }

        $token = $_COOKIE['token'];
        $userModel = new UserModel();

        // 2. Validate token với Database
        // Hàm này trong UserModel sẽ tự động khôi phục $_SESSION nếu token đúng
        if ($userModel->validateToken($token) == false) {
            // Nếu token sai (hack hoặc hết hạn) -> Xóa cookie -> Đá về login
            setcookie("token", "", time() - 3600, "/"); 
            self::redirectToLogin();
        }
    }

    /**
     * Hàm kiểm tra quyền hạn (Admin vs Student).
     * Dựa trên cột 'role' trong bảng 'users' mới.
     * * Cách dùng: AuthCore::checkPermission('admin');
     */
    public static function checkPermission($requiredRole)
    {
        // Bắt buộc phải đăng nhập trước đã
        self::checkAuthentication();

        // Kiểm tra role trong Session (được tạo ra bởi UserModel->validateToken)
        if (isset($_SESSION['user_role'])) {
            // So sánh role hiện tại với role yêu cầu (ví dụ: 'admin' == 'admin')
            if ($_SESSION['user_role'] === $requiredRole) {
                return true; // Được phép đi tiếp
            }
        }
        
        // Nếu không đủ quyền -> Chặn lại
        echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>";
        echo "<h1>Truy cập bị từ chối!</h1>";
        echo "<p>Bạn không có quyền truy cập vào trang này.</p>";
        echo "<a href='" . _BASE_URL . "home/index'>Quay về trang chủ</a>";
        echo "</div>";
        exit(); 
    }

    /**
     * Hàm nội bộ: Chuyển hướng về trang đăng nhập chuẩn.
     * Sử dụng _BASE_URL để tránh lỗi đường dẫn tương đối (nguyên nhân gây Loop).
     */
    private static function redirectToLogin()
    {
        $path = _BASE_URL . "auth/signin";
        header("Location: $path");
        exit;
    }
    public static function checkStudent() {
        self::redirectToLogin();
        if ($_SESSION['user_role'] !== 'student') {
            header('Location: ' . _BASE_URL . 'admin/dashboard');
            exit;
        }
    }
}
?>