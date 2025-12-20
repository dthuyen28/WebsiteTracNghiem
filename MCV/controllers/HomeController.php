<?php

class HomeController extends Controller
{
    public $userModel;
    public $subjectModel;

    public function __construct()
    {
        parent::__construct();

        // 1. BẮT BUỘC: Kiểm tra đăng nhập
        // Nếu chưa đăng nhập, AuthCore sẽ đá về trang auth/signin ngay lập tức
        AuthCore::checkAuthentication();

        // 2. Load các Model cần thiết
        $this->userModel = $this->model("UserModel");
        
        // (Nếu bạn đã tạo SubjectModel thì mở comment dòng này ra)
        // $this->subjectModel = $this->model("SubjectModel");
    }

    /**
     * Trang Dashboard chính của Sinh viên
     * Hiển thị danh sách môn học hoặc đề thi mới nhất
     */
    public function index()
    {
        // Lấy thông tin user hiện tại từ Session
        // (Dữ liệu này đã được lưu lúc đăng nhập trong AuthController)
        $currentUser = [
            'id' => $_SESSION['user_id'],
            'fullname' => $_SESSION['user_fullname'],
            'role' => $_SESSION['user_role']
        ];

        // Lấy danh sách môn học (Giả sử bạn sẽ viết hàm getAll trong SubjectModel)
        // $listSubjects = $this->subjectModel->getAll();
        $listSubjects = []; // Tạm thời để rỗng để code không lỗi

        // Gọi View
        $this->view("main_layout", [
            "Page" => "home/index", // Bạn cần tạo file view: MCV/views/home/index.php
            "Title" => "Trang chủ - Hệ thống trắc nghiệm",
            "User" => $currentUser,
            "Subjects" => $listSubjects,
            "Script" => "home_script", // File JS nếu cần
            "Plugin" => [
                "notify" => 1
            ]
        ]);
    }

    /**
     * Ví dụ: Trang làm bài thi
     * URL: /home/exam/1 (Làm đề thi có ID là 1)
     */
    public function exam($exam_id = null)
    {
        if (!$exam_id) {
            header("Location: " . _BASE_URL . "home/index");
            exit;
        }

        $this->view("main_layout", [
            "Page" => "home/exam_start", // Trang bắt đầu làm bài
            "Title" => "Làm bài thi",
            "ExamID" => $exam_id
        ]);
    }
}