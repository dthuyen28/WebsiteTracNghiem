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
}
