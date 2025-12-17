<?php
class usercontroller extends controller {

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userModel = $this->model("UserModel");
            $user = $userModel->checkLogin($_POST["username"], $_POST["password"]);

            if ($user) {
                $_SESSION["user"] = $user;
                header("Location: " . BASE_URL . "user/login");
                exit;
            } else {
                $error = "Sai tài khoản hoặc mật khẩu";
                $this->view("user/login", ["error" => $error]);
            }
        } else {
            $this->view("user/login");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "user/login");
    }
}
