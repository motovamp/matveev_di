<?php
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
// $dbh->exec('SET CHARACTER SET utf8');
?>