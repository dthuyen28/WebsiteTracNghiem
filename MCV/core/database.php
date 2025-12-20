<?php

class Database {
    // Biến tĩnh lưu trữ thể hiện duy nhất (Singleton)
    private static $instance = null; 
    
    // Biến lưu trữ kết nối PDO
    private $conn; 

    // Constructor Private: Chặn việc khởi tạo new Database() từ bên ngoài
    private function __construct() {
        // Lấy thông tin từ config.php để dễ quản lý
        // Nếu thay đổi host/pass, chỉ cần sửa config.php là xong
        $host = _HOST;
        $db   = _DB;
        $user = _USER;
        $pass = _PASS;
        $charset = _CHARSET;

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        
        try {
            $this->conn = new PDO($dsn, $user, $pass);
            
            // Cấu hình PDO:
            // 1. Báo lỗi dạng Exception để try-catch bắt được
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // 2. Mặc định lấy dữ liệu dạng mảng kết hợp (Associative Array)
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // 3. Tắt tính năng giả lập prepare để chống SQL Injection tốt hơn
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch (PDOException $e) {
            // Trong môi trường production, nên ghi log thay vì die()
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    // Chặn việc clone object
    private function __clone() {}

    /**
     * Lấy instance duy nhất của Database (Singleton Pattern)
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Trả về đối tượng PDO để các Model sử dụng
     * Ví dụ: $this->db->prepare(...)
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Hàm tiện ích: Thực thi query nhanh (Wrapper)
     * Giúp viết code ngắn gọn hơn trong Model
     * Ví dụ: $db->query("SELECT * FROM users WHERE id=?", [$id]);
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Lỗi truy vấn SQL: " . $e->getMessage());
        }
    }

    /**
     * Hàm tiện ích: Lấy ID vừa insert (cần thiết cho chức năng Thêm mới)
     */
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
    
    /**
     * Hàm tiện ích: Chuẩn bị câu lệnh (Proxy cho PDO::prepare)
     * Dùng khi Model gọi $this->prepare() thay vì $this->db->prepare()
     */
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
}
?>