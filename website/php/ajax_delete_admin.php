<?php
    include "connectdb.php";
    $string_array = array_values(json_decode($_POST['dataset'],true));

    $sql = "DELETE FROM admin_user WHERE am_id = ?;";
    $params = array($string_array[0]);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $str = "ได้ลบข้อมูล Admin Id : ".$string_array[0]." เสร็ดสิ้น";
    $callbackarray = array($str,0);
    echo json_encode($callbackarray,JSON_UNESCAPED_UNICODE);
?>