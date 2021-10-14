<?php
try{
//читаем параметры
$client_id = $_POST['id'];

//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таюблице
$stm = $dbh->prepare('DELETE from clients  WHERE client_id=?');
$stm->execute(array($client_id));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>