<?php
    include "connectdb.php";
    $sql = "SELECT COUNT(am_id)+1 FROM admin_user;";
    $stmt = sqlsrv_query($conn, $sql);
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        $str = $row[0];
    }
    $callbackarray = array($str);
    echo json_encode($callbackarray,JSON_UNESCAPED_UNICODE);
    sqlsrv_free_stmt($stmt);
?>