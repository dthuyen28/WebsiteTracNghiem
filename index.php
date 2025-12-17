<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = $_GET['controller'] ?? 'question';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($controller) . 'Controller';
$controllerPath = "MCV/controllers/$controllerName.php";

if (!file_exists($controllerPath)) {
    die("Controller không tồn tại: $controllerPath");
}

require_once $controllerPath;

$object = new $controllerName();

if (!method_exists($object, $action)) {
    die("Action không tồn tại");
}

$object->$action();
