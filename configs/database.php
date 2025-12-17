<?php

class Database {
    private static $conn;
    public function connectPDO (){
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Cấu hình: Báo lỗi dưới dạng Exception và lấy dữ liệu dưới dạng mảng kết hợp
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            require_once './errors/404.php';
            // Lỗi sẽ hiển thị thông báo
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }
}
?>
<?php
if(!defined('uyn')){
    die('truy cap khong hop le');

}
// ham truy van nhieu dong du lieu
function getAll($sql){
    global $conn;
    $stm = $conn -> prepare($sql);
    $stm -> execute();
    $result = $stm -> fetchAll(PDO::FETCH_ASSOC); // key chinh la ten cot  // lay ra mot dong du lieu
    return $result;
}
// dem so tra dong ve 
function getRows($sql){
    global $conn;
    $stm = $conn -> prepare($sql);
    $stm -> execute();
    $rel = $stm -> rowCount(); // key chinh la ten cot  // lay ra mot dong du lieu
    return $rel;
}
// truy van 1 dong du lieu
function getOne($sql){
    global $conn;
    $stm = $conn -> prepare($sql);
    $stm -> execute();
    $result = $stm -> fetch(PDO::FETCH_ASSOC); // key chinh la ten cot  // lay ra mot dong du lieu
    return $result;
}

// Insert du lieu
function insert($table, $data){
    /*
    $data = [
    'name' => 'uyn',
    'email' => uynle@gmai.com'
    'phone' => '01234'
    ];
    */
    global $conn;
    $keys = array_keys($data);
    $cot = implode(', ',$keys);
    $place = ':'.implode(',:',$keys);
    $sql = "INSERT INTO $table ($cot) VALUES($place)"; //:name -> placechoder
    
    $stm = $conn -> prepare($sql);//sql injection
    // thuc thi cau lenh
    $rel = $stm -> execute($data);
}

// update dữ liệu
function update($table, $data, $condition = ''){
    global $conn;
    $update = '';

    foreach($data as $key => $value){
        $update .= $key . '=:' .$key .',';
    }

    $update = trim($update, ',');

    if(!empty($condition)){
        $sql = "UPDATE $table SET $update WHERE $condition";
    }else {
        $sql = "UPDATE $table SET $update ";
    }

    // chuan chi cau lenh sql
    $tmp = $conn -> prepare($sql);

   // thuc thi cau lenh
   $tmp -> execute($data);
}

// hamf xoa du lieu 
function delete($table, $condition = ''){
    global $conn;

    if(!empty($condition)){
     $sql = "DELETE FROM $table WHERE $condition";
    }else {
        $sql = "DELETE FROM $table";
    }
    $stm = $conn -> prepare($sql);
    $stm -> execute();

}

// ham lay dong du lieu moi insert
function lastID(){
    global $conn;
    return $conn -> lastInsertID();
}
