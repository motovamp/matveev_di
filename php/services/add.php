<?php
try{
//читаем параметры
/* $client_code = isset($_POST['service_id'])?$_POST['service_id']:$_POST['id']; */
$service_id = $_POST['service_id'];
$service_name = $_POST['service_name'];
$service_cost = $_POST['service_cost'];
$service_desc = $_POST['service_desc'];
//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таюблице
$stm = $dbh->prepare("INSERT INTO services VALUES (?,?,?,?);");
$stm->execute(array($service_id, $service_name, $service_cost, $service_desc));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>