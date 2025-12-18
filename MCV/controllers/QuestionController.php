<?php

class QuestionController {

    public function index() {
        require_once 'MCV/models/QuestionModel.php';
        $model = new QuestionModel();
        $questions = $model->getAll();

        require_once 'MCV/views/question/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MCV/models/QuestionModel.php';
            $model = new QuestionModel();
            $model->add($_POST['content']);

            header('Location: index.php?controller=question&action=index');
            exit;
        }

        require_once 'MCV/views/question/create.php';
    }
}
