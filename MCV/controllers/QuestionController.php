<?php

class QuestionController extends Controller
{
    private $questionModel;

    public function __construct()
    {
        parent::__construct();
        $this->questionModel = $this->model("QuestionModel");
    }

    public function index()
{
        $questions = $this->questionModel->getAllQuestions();

        $this->view("question/index", [
            "questions" => $questions
        ]);
}
    public function create()
{
        $this->view("question/create");
}

    public function store()
{
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $content = $_POST["content"];
            $level = $_POST["level"];

            // Gọi model insert
            $this->questionModel->insertQuestion($content, $level);

            // Chuyển về danh sách
            header("Location: index.php?controller=question&action=index");
        }
    }
    public function edit($id)
{
        $question = $this->questionModel->getQuestionById($id);

        $this->view("question/edit", [
            "question" => $question
    ]);
}

    public function update($id)
{
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $content = $_POST["content"];
            $level = $_POST["level"];

            $this->questionModel->updateQuestion($id, $content, $level);

            header("Location: index.php?controller=question&action=index");
    }
}
    public function delete($id)
{
        $this->questionModel->deleteQuestion($id);
        header("Location: index.php?controller=question&action=index");
}
}

