<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
//если получен ID сессии
if (isset($_SESSION['id'])) {
	//то пользователь авторизован, редирект на страницу клиентов
	header("Location: /page/clients.php");
}
else{
	//иначе перенаправляем на страницу авторизации
	header("Location: /page/login.php");
}

exit();
?>