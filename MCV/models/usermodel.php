<?php
require_once CORE_PATH . "/BaseModel.php";

class UserModel extends BaseModel
{
    // Lấy user theo username
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->query($sql, ['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo user mới
    public function createUser($data)
    {
        $sql = "INSERT INTO users(username, password, fullname, email, role)
                VALUES(:username, :password, :fullname, :email, :role)";
        return $this->db->query($sql, $data);
    }

    // Kiểm tra đăng nhập
    public function login($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
