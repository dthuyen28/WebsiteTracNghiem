<?php

class Controller {

    // Load model
    public function model($model) {
        require_once MODEL_PATH . "/" . $model . ".php";
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        if (!empty($data)) {
            extract($data);
        }
        require_once VIEW_PATH . "/" . $view . ".php";
    }
}
