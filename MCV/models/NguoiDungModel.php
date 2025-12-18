<?php
class NguoiDungModel extends Database
{
    private $db;

    public function __construct()
    {
        // Lấy kết nối PDO từ lớp cha thông qua Singleton
        $this->db = Database::getInstance()->getConnection();
    }

    // Thêm người dùng mới
    public function create($id, $email, $fullname, $password, $ngaysinh, $gioitinh, $role, $trangthai)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `nguoidung`(`id`, `email`, `hoten`, `gioitinh`, `ngaysinh`, `matkhau`, `trangthai`, `manhomquyen`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id, $email, $fullname, $gioitinh, $ngaysinh, $passwordHash, $trangthai, $role]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa người dùng
    public function delete($id)
    {
        $sql = "DELETE FROM `nguoidung` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Cập nhật thông tin người dùng (Quản trị)
    public function update($id, $email, $fullname, $password, $ngaysinh, $gioitinh, $role, $trangthai)
    {
        $sql = "UPDATE `nguoidung` SET `email` = ?, `hoten` = ?, `gioitinh` = ?, `ngaysinh` = ?, `trangthai` = ?, `manhomquyen` = ?";
        $params = [$email, $fullname, $gioitinh, $ngaysinh, $trangthai, $role];

        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", `matkhau` = ?";
            $params[] = $passwordHash;
        }

        $sql .= " WHERE `id` = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Cập nhật hồ sơ cá nhân
    public function updateProfile($fullname, $gioitinh, $ngaysinh, $email, $id)
    {
        $sql = "UPDATE `nguoidung` SET `email` = ?, `hoten` = ?, `gioitinh` = ?, `ngaysinh` = ? WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email, $fullname, $gioitinh, $ngaysinh, $id]);
    }

    // Lấy tất cả người dùng
    public function getAll()
    {
        $sql = "SELECT nguoidung.*, nhomquyen.`tennhomquyen`
                FROM nguoidung 
                JOIN nhomquyen ON nguoidung.`manhomquyen` = nhomquyen.`manhomquyen`";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Lấy thông tin theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM `nguoidung` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Đổi mật khẩu
    public function changePassword($id, $new_password)
    {
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE `nguoidung` SET `matkhau` = ? WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$passwordHash, $id]);
    }

    // Kiểm tra Email tồn tại (trả về số dòng)
    public function checkEmailExist($email)
    {
        $sql = "SELECT COUNT(*) FROM nguoidung WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }

    // Cập nhật ảnh đại diện
    public function uploadFile($id, $tmpName, $imageExtension, $validImageExtension, $name)
    {
        if (!in_array($imageExtension, $validImageExtension)) {
            return false;
        }
        $newImageName = $name . "-" . uniqid() . '.' . $imageExtension;
        $path = './public/media/avatars/' . $newImageName;

        if (move_uploaded_file($tmpName, $path)) {
            $sql = "UPDATE `nguoidung` SET `avatar` = ? WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$newImageName, $id]);
        }
        return false;
    }

    // Lấy quyền (Role) của người dùng
    public function getRole($manhomquyen)
    {
        $sql = "SELECT chucnang, hanhdong FROM chitietquyen WHERE manhomquyen = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manhomquyen]);
        $rows = $stmt->fetchAll();

        $roles = [];
        foreach ($rows as $item) {
            $roles[$item['chucnang']][] = $item['hanhdong'];
        }
        return $roles;
    }
    /**
     * Kiểm tra token và thiết lập Session người dùng
     */
    public function validateToken($token)
    {
        $sql = "SELECT * FROM `nguoidung` WHERE `token` = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Đổ dữ liệu vào Session để AuthCore sử dụng
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_name'] = $row['hoten'];
                $_SESSION['avatar'] = $row['avatar'];
                
                // Lấy danh sách quyền chi tiết
                $_SESSION['user_role'] = $this->getRole($row['manhomquyen']);
                
                return true;
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

    /**
     * Cập nhật Token khi đăng nhập thành công
     */
    public function updateToken($id, $token)
    {
        $sql = "UPDATE `nguoidung` SET `token` = ? WHERE `id` = ?";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$token, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}