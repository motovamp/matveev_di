<?php
try{
//читаем параметры
$service_id = isset($_POST['service_id'])?$_POST['service_id']:$_POST['id'];
/* $service_id = $_POST['service_id']; */
$service_name = $_POST['service_name'];
$service_cost = $_POST['service_cost'];
$service_desc = $_POST['service_desc'];
//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таблице
$stm = $dbh->prepare('UPDATE services SET service_name=?, service_cost=?, service_desc=? WHERE service_id=?');
$stm->execute(array($service_name, $service_cost, $service_desc, $service_id));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>