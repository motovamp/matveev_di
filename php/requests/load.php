<?php
try{
//читаем параметры
$request_id = isset($_POST['request_id'])?$_POST['request_id']:$_POST['id'];
/* $request_id = $_POST['request_id']; */
$client_id = $_POST['client_id'];
$service_id = $_POST['service_id'];
$re_type = $_POST['re_type'];
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
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таблице
$stm = $dbh->prepare('UPDATE requests SET client_id=?, service_id=?, re_type=?, rq_date=?, rq_status=?, rq_pay=?, obj_sum=?, obj_rooms=?, obj_size=?, obj_floor=?, obj_floors=?, obj_district=?, obj_address=?, rq_note=? WHERE request_id=?');
$stm->execute(array($client_id, $service_id, $re_type, $rq_date, $rq_status, $rq_pay, $obj_sum, $obj_rooms, $obj_size, $obj_floor, $obj_floors, $obj_district, $obj_address, $rq_note, $request_id));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>