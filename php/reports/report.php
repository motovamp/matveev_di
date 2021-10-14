<?php
try{
	//получаем в переменную ID выбранной строки
	$id = $_GET['id'];
	//echo "ID выбранной строки: ", $id;
	/* $curPage = $_POST['page'];
	$rowsPerPage= $_POST['rows'];
	$sortingField= $_POST['sidx'];
	$sortingOrder= $_POST['sord']; */
	
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
	
	$qPeriod = 'с '.$qYear.'-'.$qMonth.'-01 по '.$qDate;
	$str = iconv('utf-8','windows-1251',$qPeriod);
	$output = str_replace('<<period>>',$str,$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<all>>',$row['count'],$output);
		
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND rq_status = "Активна"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<active>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND rq_status = "Закрыта"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<not_active>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND rq_pay = "Оплачена"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<payed>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND rq_pay = "Не оплачена"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<not_payed>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND service_name = "Покупка"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<buy>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND service_name = "Продажа"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<sell>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND service_name = "Найм"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<occup>>',$row['count'],$output);
	
	$res = $dbh->query('SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id WHERE DATE(rq_date) >= "'.$qYear.'-'.$qMonth.'-01" AND DATE(rq_date) <= "'.$qYear.'-'.$qMonth.'-31" AND service_name = "Аренда"');
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$output = str_replace('<<lease>>',$row['count'],$output);
		
	//отправляем результат
	echo $output;
}
catch(PDOException $e){
	echo 'Database error: '.$e->getMessage();
}	
?>