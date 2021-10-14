<?php
session_start();//вся процедура работает на сессиях 
header("Content-Type: text/html; charset=utf-8");

//заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['login'])){
	$login = $_POST['login'];
	if ($login == ''){
		unset($login);
	}
}
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])){
	$password=$_POST['password'];
	if ($password ==''){
		unset($password);
	}
}
//если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
if (empty($login) or empty($password)){
	echo '<script type="text/javascript">;
	confirm("Пожалуйства, введите логин и пароль.");
	location.replace("../../page/login.php");
	</script>';
}
//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);

$password = stripslashes($password);
$password = htmlspecialchars($password);

//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);

//делаем хеш пароля
$password = md5($password);


// подключаемс¤ к базе
include ("../connect.php");//должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

$result = $dbh->query("SELECT * FROM users WHERE user_login='$login'"); //извлекаем из базы все данные о пользователе с введенным логином
$row = $result->fetch(PDO::FETCH_ASSOC);;
if (empty($row['user_password'])){
	//если пользователя с введенным логином не существует
	echo '<script type="text/javascript">;
	confirm("Пользователь не найден.");
	location.replace("../../page/login.php");
	</script>';
}
else{
	//если существует, то сверяем пароли
	if ($row['user_password']==$password){
		//если пароли совпадают, то запускаем пользователю сессию!
		$_SESSION['login']=$row['user_login']; 
		$_SESSION['id']=$row['user_id'];//эти данные пользователь будет "носить с собой"
		echo '<script type="text/javascript">;
		location.replace("../../index.php");
		</script>';
    }
	else{
		//если пароли не сошлись
		echo '<script type="text/javascript">;
		confirm("Введенный пароль неверный.");
		location.replace("../../page/login.php");
		</script>';
	}
}
?>