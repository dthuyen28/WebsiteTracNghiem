<?php
// File: MCV/models/UserModel.php

class UserModel extends Database
{
    private $db;

    public function __construct()
    {
        // Lấy kết nối PDO
        $this->db = Database::getInstance()->getConnection();
    }

    // 1. Kiểm tra đăng nhập (Sửa lại theo bảng users)
    public function checkLogin($username, $password)
    {
    
        $sql = "SELECT * FROM `users` WHERE `username` = ?";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra mật khẩu
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
        } catch (PDOException $e) {
            // Log error nếu cần
            return false;
        }
        return false;
    }

    // 2. Thêm người dùng mới (Đăng ký)
    public function create($username, $password, $fullname, $email, $role = 'student')
    {
        // Kiểm tra xem username đã tồn tại chưa
        if ($this->checkUsernameExist($username)) {
            return "Username đã tồn tại";
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Cấu trúc INSERT khớp với bảng users
        $sql = "INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `role`) 
                VALUES (?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$username, $passwordHash, $fullname, $email, $role]);
            return $result ? true : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // 3. Cập nhật Token (Để ghi nhớ đăng nhập)
    public function updateToken($id, $token)
    {
        // Cần chạy lệnh ALTER TABLE users ADD token ... trước
        $sql = "UPDATE `users` SET `token` = ? WHERE `id` = ?";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$token, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // 4. Validate Token (Dùng cho AuthCore check cookie)
    public function validateToken($token)
    {
        $sql = "SELECT * FROM `users` WHERE `token` = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Tái tạo lại Session
                $this->setUserSession($user);
                return true;
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

    // 5. Hàm phụ trợ: Lưu session
    private function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_fullname'] = $user['fullname'];
        $_SESSION['user_role'] = $user['role']; // 'admin' hoặc 'student'
        $_SESSION['user_email'] = $user['email'];
    }

    // 6. Kiểm tra Username tồn tại
    public function checkUsernameExist($username)
    {
        $sql = "SELECT COUNT(*) FROM `users` WHERE `username` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
    
    // 7. Lấy thông tin user theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
     // 8. Đổi mật khẩu
    public function changePassword($id, $new_password)
    {
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET `password` = ? WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$passwordHash, $id]);
    }

    // Cập nhật thông tin (Chỉ update fullname và email)
    public function updateProfile($id, $fullname, $email)
    {
        $sql = "UPDATE `users` SET `fullname` = ?, `email` = ? WHERE `id` = ?";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fullname, $email, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra Email đã tồn tại chưa (trừ chính user đó ra thì xử lý ở Controller rồi)
    public function checkEmailExist($email)
    {
        $sql = "SELECT COUNT(*) FROM `users` WHERE `email` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    public function getAll() {
    $sql = "SELECT * FROM `users` ORDER BY id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
    $sql = "DELETE FROM `users` WHERE `id` = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$id]);
    }
    // Thêm vào UserModel.php

    // Admin cập nhật thông tin User (Bao gồm cả Role và Password)
    public function updateUserByAdmin($id, $fullname, $email, $role, $password = null)
    {
        // 1. Câu lệnh update cơ bản
        $sql = "UPDATE `users` SET `fullname` = ?, `email` = ?, `role` = ?";
        $params = [$fullname, $email, $role];

        // 2. Nếu admin nhập mật khẩu mới -> Cập nhật luôn mật khẩu
        if (!empty($password)) {
            $sql .= ", `password` = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE `id` = ?";
        $params[] = $id;

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
}