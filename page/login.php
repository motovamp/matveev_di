<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
<!-- CSS //-->
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<title>Авторизация</title>
</head>
<body>
	<div id="login-form">
		<fieldset>
			<form action="../php/auth/auth.php" method="post">
				<input name="login" type="text" value="Логин" id="login" onBlur="if(this.value=='')this.value='Логин'" onFocus="if(this.value=='Логин')this.value='' " />
				<input name="password" type="password" value="Пароль" id="password" onBlur="if(this.value=='')this.value='Пароль'" onFocus="if(this.value=='Пароль')this.value='' "/>
				<input name="submit" type="submit" value="ВОЙТИ" />
			</form>
		</fieldset>
	</div>
</body>
</html>