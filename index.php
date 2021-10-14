<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
//если получен ID сессии
if (isset($_SESSION['id'])){
	//то пользователь авторизован, ничего не делаем
}
else{
	//иначе перенаправляем на страницу авторизации
	echo '<script type="text/javascript">;
	location.replace("page/login.php");
	</script>';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
<!-- CSS //-->
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<title>Главная</title>
</head>
<body>
<!-- CONTENT CONTAINER //-->
	<!--<div id="content">
		<div id="content_inner" align="center">//-->
<!-- CONTENT //-->
			<div id="index_menu" align="center">
				<ul id="main_menu">
					<li><a id="main_menu_link" href="page/clients.php">Клиенты</a></li>
					<li><a id="main_menu_link" href="page/requests.php">Заявки</a></li>
					<li><a id="main_menu_link" href="page/services.php">Услуги</a></li>
					<li><a id="main_menu_link" href="page/reports.php">Отчеты</a></li>
					<li><a id="main_menu_link" href="php/auth/exit.php">Выход</a></li>
				</ul>
			</div>
			
<!-- END OF CONTENT //-->
		<!--</div>
	</div>//-->
</body>
</html>