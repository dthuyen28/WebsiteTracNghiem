
<?php
// system
const uyn = true;

const _MODULES = 'dashboard';
const _ACTION = 'index';

// khai báo database
const _HOST = 'localhost';
const _DB = 'tracnghiem';
const _USER = "root";
const _PASS = '';
const _DRIVER = 'mysql';

// debug error
const _DEBUG = true;
// url
const _BASE_URL ='http://localhost/Tracnghiem/wbTracnghiem'

// thiết lập host
//echo 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course';
define('_HOST_URL', 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course');
define('_HOST_URL_TEMPLATES', 'http:'. $_SERVER['HTTP_HOST'] . '/manager_course/templates');
// echo _HOST_URL;
// echo _HOST_URL_TEMPLATES;

// thiết lập path
define('_PATH_URL',__DIR__);
define('_PATH_URL_TEMPLATES', _PATH_URL. '/templates');

echo _HOST_URL .'<br>';
echo _HOST_URL_TEMPLATES .'<br>';
echo _PATH_URL .'<br>';
echo _PATH_URL_TEMPLATES .'<br>';
echo 'http:' . $_SERVER['HTTP_HOST'] . '/tracnghiem';