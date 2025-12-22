<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load cấu hình
require_once "config.php";

// Load Database (Singleton)
require_once "MCV/core/Database.php";

// Load QuestionModel
require_once "MCV/models/QuestionModel.php";

// Test
$model = new QuestionModel();
$questions = $model->getAllQuestions();

// Hiển thị kết quả
echo "<pre>";
print_r($questions);
