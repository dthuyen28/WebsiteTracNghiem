<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

//echo date('Y:m:d H:i:s');
session_start();
ob_start(); //header

require_once 'config.php';

require_once './includes/connect.php';
require_once './configs/database.php';

// require_once './modules/auth/login.php';

//$rel = getAll("SELECT * FROM subject");
//$rel = getOne("SELECT * FROM subject");
$data = [
    'name' => 'Tên Môn Học',
    // Thêm các cặp khóa-giá trị tương ứng với các cột bạn muốn chèn
];
insert('questions',$data);
echo '<pre>';
print_r($rel);
echo '</pre>';
die();
$module = _MODULES;
$action = _ACTION;

if (!empty($_GET['module'])){
    $module = $_GET['module'];
}
if (!empty($_GET['action'])){
    $action = $_GET['action'];
}

$path = 'modules/' . $module . '/' . $action . '.php';
if(!empty($path)){
    if(file_exists($path)){
        require_once $path;
        echo 'Kết nối thành công';
    }else {
        require_once './modules/errors/404.php';
    }

}else{
    require_once './modules/errors/500.php';
}
echo "<p style='color: green; font-weight: bold;'>✅ KẾT NỐI THÀNH CÔNG!</p>";
?>



