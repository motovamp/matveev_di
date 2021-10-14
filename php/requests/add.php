<?php
/* session_start();//вся процедура работает на сессиях 
header("Content-Type: text/html; charset=utf-8"); */
try{
//читаем параметры
/* $client_code = isset($_POST['request_id'])?$_POST['request_id']:$_POST['id']; */
$request_id = $_POST['request_id'];
$client_id = $_POST['client_id'];
$service_id = $_POST['service_id'];
//$contract_num = $_POST['contract_num'];
$rq_date = $_POST['rq_date'];
$rq_status = $_POST['rq_status'];
$rq_pay = $_POST['rq_pay'];
$obj_sum = $_POST['obj_sum'];
$obj_rooms = $_POST['obj_rooms'];
$obj_size = $_POST['obj_size'];
$obj_floor = $_POST['obj_floor'];
$obj_floors = $_POST['obj_floors'];
$obj_district = $_POST['obj_district'];
$obj_address = $_POST['obj_address'];
$rq_note = $_POST['rq_note'];
//подключаемся к базе
include ("../connect.php");
/* ПОТОМ УДАЛЮ ЭТО ГОВНО РАБОТАЕТ НЕ ТАК
$dbh = new PDO('mysql:host=localhost;dbname=matveev_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
/* $res1 = $dbh->query('SELECT COUNT(client_id) AS count FROM clients WHERE client_id = '.$client_id);
$row1 = $res1->fetch(PDO::FETCH_ASSOC);

$res2 = $dbh->query('SELECT COUNT(service_id) AS count FROM services WHERE service_id = '.$service_id);
$row2 = $res2->fetch(PDO::FETCH_ASSOC);
if(($row1['count'] == 0) || ($row2['count'] ==0)){
	echo '<script type="text/javascript">;
	confirm("Ошибка. Такого клиента или услуги не существует");
	location.replace("../../page/requests/requests.php");
	</script>';
}
else{ */
//определяем количество записей в таюблице
//$stm = $dbh->prepare("INSERT INTO requests VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
$stm = $dbh->prepare("INSERT INTO requests (request_id, client_id, service_id, contract_num, rq_date, rq_status, rq_pay, obj_sum, obj_rooms, obj_size, obj_floor, obj_floors, obj_district, obj_address, rq_note) SELECT ?,?,?,max(contract_num)+1,?,?,?,?,?,?,?,?,?,?,? FROM requests;");
$stm->execute(array($request_id, $client_id, $service_id,/* $contract_num,*/ $rq_date, $rq_status, $rq_pay, $obj_sum, $obj_rooms, $obj_size, $obj_floor, $obj_floors, $obj_district, $obj_address, $rq_note));
//}
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>