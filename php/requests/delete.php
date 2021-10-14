<?php
try{
//читаем параметры
$request_id = $_POST['id'];

//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таюблице
$stm = $dbh->prepare('DELETE from requests  WHERE request_id=?');
$stm->execute(array($request_id));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>