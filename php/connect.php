<?php
/** Файл образца настроек подключения к бд 
 * при наличия файла connect-local.php будет использован он
*/

if(file_exists(__DIR__."/connect-local.php")) {
    require_once(__DIR__."/connect-local.php");
} else {
    $host = '127.0.0.1';
    $db   = 'matveev_db';
    $user = 'root';
    $pass = 'rootpasswd';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    );
    $dbh = new PDO($dsn, $user, $pass, $opt);
}
?>