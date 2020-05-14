<?php
    include "connectdb.php";
    //แปลง json เป็น array php 
    $string_array = array_values(json_decode($_POST['dataset'],true));
    $am_id = $string_array[0];
    $de_id = 0;
    $sql = "SELECT de_id ".
            "FROM department_table ".
            "WHERE de_name = N'".$string_array[4]."';";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        $de_id = (int)$row[0];
    }
    $sql = "UPDATE admin_user ".
           "SET am_id = ?,am_prefix = ?,am_firstname = ?,am_lastname = ?,am_department_id = ? ,am_level = ? , am_email = ? ".
           "WHERE am_id = ?;";
    $params = array($string_array[0],$string_array[1],$string_array[2],$string_array[3],$de_id,(int)$string_array[5],$string_array[6],$am_id);
    $stmt = sqlsrv_query( $conn, $sql, $params);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $str = "แก้ไขข้อมูล (".$string_array[1]." "."$string_array[2]"." ".$string_array[3].") สำเร็จ";
    $callbackarray = array($str);
    // แปลง array() ให้เป็น json
    echo json_encode($callbackarray,JSON_UNESCAPED_UNICODE);
?>