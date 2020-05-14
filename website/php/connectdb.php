<?php
    $serverName = "DESKTOP-G7HRNUJ"; //serverName\instanceName

    // Since UID and PWD are not specified in the $connectionInfo array,
    // The connection will be attempted using Windows Authentication.
    $connectionInfo = array( "Database"=>"MRS_for_engineering_student","CharacterSet" => "UTF-8");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        //echo "Connection established.<br />";
    }else{
        //echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    }
?>