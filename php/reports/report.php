<?php
try{
	//получаем в переменную ID выбранной строки
	$match = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
	$ds = isset($_GET['start']) && preg_match($match, $_GET['start']) ? $_GET['start'] : date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
	$de = isset($_GET['end']) && preg_match($match, $_GET['end']) ? $_GET['end'] : date('Y-m-d');
	
	//устанавливаем заголовки для корректной работы
	//header('Content-Type: text/html; charset = utf-8');
	header('Content-Type: text/html; charset = windows-1251');
    header('Content-Type: application/msword');
    header('Content-Disposition: inline; filename=report.rtf');//стереть id
	
	//открываем шаблон
	$filename = 'template.rtf';
    $output = file_get_contents($filename);
	
	//подключаемся к базе
	include ("../connect.php");
	/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root','157266');
	$dbh->exec('SET CHARACTER SET utf8'); */
	
	$qDate = date('Y-m-d');
	$qDateArray = explode("-",$qDate);
	$qYear = $qDateArray[0];
	$qMonth = $qDateArray[1];
	
	$qPeriod = 'с '.$ds.' по '.$de;
	$str = iconv('utf-8','windows-1251',$qPeriod);
	$output = str_replace('<<period>>',$str,$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<all>>',$row['count'],$output);
		
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND rq_status = "Активна"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<active>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND rq_status = "Закрыта"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<not_active>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND rq_pay = "Оплачена"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<payed>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND rq_pay = "Не оплачена"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<not_payed>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND service_name = "Покупка"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<buy>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND service_name = "Продажа"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<sell>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND service_name = "Найм"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<occup>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'" AND service_name = "Аренда"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<lease>>',$row['count'],$output);
		
	//отправляем результат
	echo $output;
}
catch(PDOException $e){
	echo 'Database error: '.$e->getMessage();
}	
?>