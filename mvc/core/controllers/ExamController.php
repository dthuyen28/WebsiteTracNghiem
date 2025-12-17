<?php

class ExamController {

    public function index() {
        require "./mvc/exam/do.php";
    }

    public function result() {
        require "./mvc/exam/result.php";
    }
}

