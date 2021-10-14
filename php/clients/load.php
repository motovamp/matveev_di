<?php
try{
//читаем параметры
$client_id = isset($_POST['client_id'])?$_POST['client_id']:$_POST['id'];
/* $client_id = $_POST['client_id']; */
$f_fio = $_POST['f_fio'];
$i_fio = $_POST['i_fio'];
$o_fio = $_POST['o_fio'];
$passport_num = $_POST['passport_num'];
$passport_date = $_POST['passport_date'];
$passport_place = $_POST['passport_place'];
$tel = $_POST['tel'];
//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */
//определяем количество записей в таблице
$stm = $dbh->prepare('UPDATE clients SET f_fio=?, i_fio=?, o_fio=?, passport_num=?, passport_date=?, passport_place=?, tel=? WHERE client_id=?');
$stm->execute(array($f_fio, $i_fio, $o_fio, $passport_num, $passport_date, $passport_place, $tel, $client_id));
}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>