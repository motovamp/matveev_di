<?php
try {
    
    include ("../connect.php");

    $responce = array('clients' => array(), 'services' => array());

    $res = $dbh->query('SELECT * FROM clients');
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        // $response['clients'][] = array('id' => $row['client_id'], 'value' => $row['f_fio'].' '.$row['i_fio'].' '.$row['tel']);
        $response['clients'][] = $row['client_id'].':'.$row['f_fio'].' '.$row['i_fio'].' '.$row['tel'];
    }

    $res = $dbh->query('SELECT * FROM services');
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        // $response['services'][] = array('id' => $row['service_id'], 'value' => $row['service_name'].' '.$row['service_cost']);
        $response['services'][] = $row['service_id'].':'.$row['service_name'].' '.$row['service_cost'];
    }

    echo json_encode($response);
} catch(PDOException $e) {
    echo 'Database error: '.$e->getMessage();
}