<?php
    include "connectdb.php";
    $output = '';
    if(isset($_POST["search"]))
    {
        $sql = "SELECT am_id,am_prefix,am_firstname,am_lastname,de_name,am_level,am_email ".
           "FROM admin_user ".
           "LEFT JOIN department_table ".
           "ON admin_user.am_department_id = department_table.de_id ".
           "WHERE am_id LIKE '%".$_POST["search"]."%';";
    }
    else{
        $sql = "SELECT am_id,am_prefix,am_firstname,am_lastname,de_name,am_level,am_email ".
               "FROM admin_user ".
               "LEFT JOIN department_table ".
               "ON admin_user.am_department_id = department_table.de_id ;";
    }
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        $output .= "<tr>".
                        "<td>".$row[0]."</td>".
                        "<td>".$row[1]."</td>".
                        "<td>".$row[2]."</td>".
                        "<td>".$row[3]."</td>".
                        "<td>".$row[4]."</td>".
                        "<td>".$row[5]."</td>".
                        "<td>".$row[6]."</td>".
                        "<td>".
                            "<a class='add'  data-toggle='tooltip'><i class='fas fa-lg fa-user-plus text-success'></i></a>".
                            "<a class='edit' data-toggle='tooltip' id='".$row[0]."'><i class='fas fa-lg fa-pencil-alt text-warning'></i></a>".
                            "<a class='delete' data-toggle='tooltip' id='".$row[0]."'><i class='fas fa-lg fa-trash text-danger'></i></a>".
                        "</td>".
                    "</tr>";
    }
    echo $output;
    sqlsrv_free_stmt($stmt);
?>