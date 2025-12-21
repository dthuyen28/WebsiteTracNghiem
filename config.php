
<?php
// system
const uyn = true;
define('_IN_SYSTEM', true);
const _MODULES = 'dashboard';
const _ACTION = 'index';

// khai báo database
const _HOST = 'localhost';
const _DB = 'tracnghiem';
const _USER = "root";
const _PASS = '';
const _DRIVER = 'mysql';
const _CHARSET = 'utf8mb4';

// debug error
const _DEBUG = true;
define('_BASE_URL', 'http://localhost/Tracnghiem/WebsiteTracnghiem/');
// url


// thiết lập host
//echo 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course';
// define('_HOST_URL', 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course');
// define('_HOST_URL_TEMPLATES', 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course/templates');
// echo _HOST_URL;
// echo _HOST_URL_TEMPLATES;

// thiết lập path
define('_PATH_URL',__DIR__);
define('_PATH_URL_TEMPLATES', _PATH_URL. '/templates');


// đường dẫn gốc
define("ROOT_PATH", __DIR__);

// MVC paths
define("MCV_PATH", ROOT_PATH . "/MCV");
define("CORE_PATH", MCV_PATH . "/core");
define("MODEL_PATH", MCV_PATH . "/models");
define("CONTROLLER_PATH", MCV_PATH . "/controllers");
define("VIEW_PATH", MCV_PATH . "/views");


// Nạp các file lõi hệ thống
require_once CORE_PATH . "/Database.php";
require_once CORE_PATH . "/Controller.php"; // Nạp class cha trước
require_once CORE_PATH . "/App.php";

// echo _HOST_URL .'<br>';
// echo _HOST_URL_TEMPLATES .'<br>';
// echo _PATH_URL .'<br>';
// echo _PATH_URL_TEMPLATES .'<br>';
// echo 'http:' . $_SERVER['HTTP_HOST'] . '/tracnghiem';

