<?php
    $resul = array(
        array('emp_no'=> 1001 ,'frist_name' => 'Kongthap' , 'last_name' => 'Thammachat'),
        array('emp_no'=> 1002 ,'frist_name' => 'Papop' , 'last_name' => 'Porking')
    );
    $json = json_encode($resul);
    echo $json;
?>