<?php
include "config.php";

if ($conn->ping()) {
    echo "Kết nối database thành công!";
} else {
    echo "Kết nối thất bại!";
}
?>