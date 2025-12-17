<?php

class QuestionModel {

    public function getAll() {
        if (!isset($_SESSION['questions'])) {
            $_SESSION['questions'] = [];
        }
        return $_SESSION['questions'];
    }

    public function add($content) {
        if (!isset($_SESSION['questions'])) {
            $_SESSION['questions'] = [];
        }
        $_SESSION['questions'][] = [
            'content' => $content
        ];
    }
}
