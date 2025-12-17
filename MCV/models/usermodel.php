<?php
class UserModel extends Database {

    public function checkLogin($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->query($sql, [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            return $user;
        }
        return false;
    }
}
