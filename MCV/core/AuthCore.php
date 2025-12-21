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
        if (isset($_SESSION['user'])) {
            header("Location: " . _BASE_URL . "home");
            exit();
        }
        if (isset($_COOKIE['token'])) {
            $userModel = new UserModel();
            $token = $_COOKIE['token'];
            $user = $userModel->validateToken($token);
            
            // Kiểm tra token có khớp trong DB không
            if ($user) {
                $userModel->setUserSession($user);
                // Nếu đúng -> Chuyển hướng về trang chủ
                header("Location: " . _BASE_URL . "home");
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
        if (!isset($_SESSION['user'])) {
            if (isset($_COOKIE['token'])) {
                $token = $_COOKIE['token'];
                $userModel = new UserModel();
                $user = $userModel->validateToken($token);
                if ($user) {
                    $userModel->setUserSession($user);
                    return;
                }
            }
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
        if (isset($_SESSION['user']['role'])) {
            // So sánh role hiện tại với role yêu cầu (ví dụ: 'admin' == 'admin')
            if ($_SESSION['user']['role'] === $requiredRole) {
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
        setcookie("token", "", time() - 3600, "/");
        header("Location: " . _BASE_URL . "auth/signin");
        exit;
    }
    public static function checkStudent() {
        setcookie("token", "", time() - 3600, "/");
        if ($_SESSION['user_role'] !== 'student') {
            header('Location: ' . _BASE_URL . 'admin/dashboard');
            exit;
        }
    }
}
?>