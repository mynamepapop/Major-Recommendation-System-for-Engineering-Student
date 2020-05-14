<?php
    include "connectdb.php";
    $state = 0;
    //แปลง json เป็น array php 
    $string_array = array_values(json_decode($_POST['dataset'],true));
    $am_id = $string_array[0];
    //เช็ค ASCII str
    $sql = "SELECT am_id ".
        "FROM admin_user ".
        "WHERE am_id = '".$am_id."';";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        if($am_id == $row[0]){
            //หาเจอแต่เท่ากัน
            $state = 2;
        }
    }
    else{
        //หาไม่เจอ
        $state = 1;
    }
    sqlsrv_free_stmt($stmt);
    
    if($state == 1){
        $de_id = 0;
        $sql = "SELECT de_id ".
               "FROM department_table ".
               "WHERE de_name = N'".$string_array[4]."'";
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
            $de_id = $row[0];
        }

        sqlsrv_free_stmt( $stmt);
        
        $sql = "INSERT INTO admin_user ( am_id , am_prefix , am_firstname , am_lastname , am_department_id , am_level , am_email , am_password) VALUES (?,?,?,?,?,?,?,dbo.fncEncode(?));";
        $params = array($string_array[0] , $string_array[1] , $string_array[2] , $string_array[3] , $de_id , (int)$string_array[5] , $string_array[6] , $string_array[7]);
        $stmt = sqlsrv_query( $conn, $sql, $params);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        
        $str = "เพิ่มข้อมูลของ (".$string_array[1]." ".$string_array[2]." ".$string_array[3].") เสร็ดสิ้น";
        $callbackarray = array($str,1);
        // แปลง array() ให้เป็น json
        echo json_encode($callbackarray,JSON_UNESCAPED_UNICODE);
    }
    else if($state == 2){
        // แปลง array() ให้เป็น json
        $str = "ID admin (' ".$string_array[0].") มีผู้ใช้งานแล้วกรุณากรอกข้อมูลใหม่";
        $callbackarray = array($str,2);
        echo json_encode($callbackarray,JSON_UNESCAPED_UNICODE);
    }
?>