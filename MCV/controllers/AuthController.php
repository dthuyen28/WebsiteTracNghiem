<?php

class AuthController extends Controller {

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $userModel = $this->model("UserModel");
            $user = $userModel->getUserByUsername($username);

            if ($user && $user['password'] === $password) {
                session_start();
                $_SESSION['user'] = $user;
                echo "Đăng nhập thành công!";
            } else {
                echo "Sai tài khoản hoặc mật khẩu!";
            }

        } else {
            // GET → hiển thị form
            $this->view("auth/login");
        }
    }
    public function register()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = [
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'fullname' => $_POST['fullname'],
            'email'    => $_POST['email'],
            'role'     => 'student'
        ];

        $userModel = $this->model("UserModel");
        $userModel->createUser($data);

        echo "Tạo user thành công!";
    } else {
        $this->view("auth/register");
    }
}

}

