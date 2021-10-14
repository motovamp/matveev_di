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
    header('Content-Disposition: inline; filename=contract.rtf');//стереть id
	
	//открываем шаблон
	$filename = 'template.rtf';
    $output = file_get_contents($filename);
	
	//подключаемся к базе
	include ("../connect.php");
	/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root','157266');
	$dbh->exec('SET CHARACTER SET utf8'); */
	
	//определяем количество записей в таблице
	$rows = $dbh->query('SELECT COUNT(request_id) AS count FROM requests WHERE request_id = '.$id);
	$totalRows = $rows->fetch(PDO::FETCH_ASSOC);
	$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;
	
	//получаем данные из базы
	$res = $dbh->query('SELECT request_id, contract_num, rq_date, f_fio, i_fio, o_fio, passport_num, passport_place, service_name, obj_sum, obj_rooms, obj_size, obj_floor, obj_floors, obj_district, service_cost FROM  requests JOIN clients ON requests.client_id = clients.client_id JOIN services ON requests.service_id = services.service_id WHERE request_id = '.$id);
	
	//обрабатываем строку
	$i=0;
	while($row = $res->fetch(PDO::FETCH_ASSOC)){
		$response->rows[$i]['request_id']=$row['request_id'];
		$response->rows[$i]['cell']=array($row['request_id'],$row['contract_num'],$row['rq_date'],$row['f_fio'],$row['i_fio'],$row['o_fio'],$row['passport_num'],$row['passport_place'],$row['service_name'],$row['obj_sum'],$row['obj_rooms'],$row['obj_size'],$row['obj_floor'],$row['obj_floors'],$row['obj_district'],$row['service_cost']);
		$i++;
	
		//выгружаем полученные данные в файл
		//договор
		$output = str_replace('<<contract_num>>',$row['contract_num'],$output);
		//дата
		$output = str_replace('<<rq_date>>',$row['rq_date'],$output);
		//соединяем ФИО в одну строку
		$fio = $fio.$row['f_fio'].' '.$row['i_fio'].' '.$row['o_fio'];
		//конвертируем строковое значение между кодировками и выводим ФИО
		$str = iconv('utf-8','windows-1251',$fio);
		$output = str_replace('<<fio>>',$str,$output);
		//паспорт
		$str = iconv('utf-8','windows-1251',$row['passport_num']);
		$output = str_replace('<<passport_num>>',$row['passport_num'],$output);
		//прописка
		$str = iconv('utf-8','windows-1251',$row['passport_place']);
		$output = str_replace('<<passport_place>>',$str,$output);
		//услуга
		$str = iconv('utf-8','windows-1251',$row['service_name']);
		$output = str_replace('<<service_name>>',$str,$output);
		//сумма
		$output = str_replace('<<obj_sum>>',$row['obj_sum'],$output);
		//комнаты
		$output = str_replace('<<obj_rooms>>',$row['obj_rooms'],$output);
		//площадь
		$output = str_replace('<<obj_size>>',$row['obj_size'],$output);
		//этаж
		$output = str_replace('<<obj_floor>>',$row['obj_floor'],$output);
		//этажность
		$output = str_replace('<<obj_floors>>',$row['obj_floors'],$output);
		//район
		$str = iconv('utf-8','windows-1251',$row['obj_district']);
		$output = str_replace('<<obj_district>>',$str,$output);
		//сумма оплаты
		$output = str_replace('<<service_cost>>',$row['service_cost'],$output);
		
	}// end WHILE
	
	//отправляем результат
	echo $output;
	//echo 'ID=',$id;
	/* echo $id;
	echo $row['request_id'];
	echo $row['f_fio'];
	echo $row['service_name']; */
	//echo json_encode($response);
	
}
catch(PDOException $e){
	echo 'Database error: '.$e->getMessage();
}	
?>