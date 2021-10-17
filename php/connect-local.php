<?php
/** Файл образца настроек подключения к бд 
 * при наличия файла connect-local.php будет использован он
*/
$host = '192.168.1.201';
$db   = 'nikulin_db';
$user = 'webclient';
$pass = 'nimdapasswd2015';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
);
$dbh = new PDO($dsn, $user, $pass, $opt);
?>