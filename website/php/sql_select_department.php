<?php
    include "connectdb.php";
    $output = '';
    $sql = "SELECT de_name ".
           "FROM department_table; ";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }
    echo $output;
    sqlsrv_free_stmt($stmt);
?>