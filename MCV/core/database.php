<?php

class Database {
    // Biến tĩnh (static) lưu trữ thể hiện (instance) duy nhất
    private static $instance = null; 
    private $conn; // Biến lưu trữ kết nối PDO
    
    // !!! THAY ĐỔI CÁC THÔNG SỐ NÀY !!!
    private $host = 'localhost'; // Tên máy chủ (thường là localhost)
    private $db_name = 'tracnghiem'; // Tên CSDL đã tạo ở bước 1
    private $username = 'root'; // Tên người dùng CSDL (thường là root)
    private $password = ''; // Mật khẩu CSDL (Mặc định XAMPP là rỗng '')
    // **********************************

    // Hàm tạo (constructor) bị chặn bên ngoài để chỉ Singleton mới dùng được
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Cấu hình: Báo lỗi dưới dạng Exception và lấy dữ liệu dưới dạng mảng kết hợp
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Lỗi sẽ hiển thị thông báo
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    // Chặn việc clone đối tượng (để đảm bảo tính duy nhất)
    private function __clone() {}

    /**
     * Phương thức tĩnh để lấy thể hiện (instance) duy nhất của lớp Database
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Lấy đối tượng kết nối PDO đã được thiết lập
     * @return PDO
     */
    public function getConnection() {
        return $this->conn;
    }
    /**
 * Hàm thực thi truy vấn SQL có tham số (Prepare Statement)
 */
public function query($sql, $params = []) {
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}
}
?>