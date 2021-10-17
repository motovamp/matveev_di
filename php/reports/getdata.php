<?php
try{
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage= $_POST['rows'];
$sortingField= $_POST['sidx'];
$sortingOrder= $_POST['sord'];
//подключаемся к базе
include ("../connect.php");
$match = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
$ds = isset($_GET['start']) && preg_match($match, $_GET['start']) ? $_GET['start'] : date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
$de = isset($_GET['end']) && preg_match($match, $_GET['end']) ? $_GET['end'] : date('Y-m-d');

//определяем количество записей в таблице
$where = '';
if(true) {
	$where .= 'WHERE DATE(rq_date) >= "'.$ds.'" AND DATE(rq_date) <= "'.$de.'"';
}


$req = 'SELECT COUNT(request_id) AS count FROM requests JOIN services ON requests.service_id = services.service_id '.$where;


$rows = $dbh->query($req);
$totalRows = $rows->fetch(PDO::FETCH_ASSOC);
$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;
//получаем список пользователей из базы
$req = 'SELECT * FROM requests JOIN services ON requests.service_id = services.service_id '.$where;
$res = $dbh->query($req.' ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response->page =  $curPage;
$response->total = ceil($totalRows['count'] / $rowsPerPage);
$response->records = $totalRows['count'];
$response->request = $req;

$i=0;
while($row = $res->fetch(PDO::FETCH_ASSOC)){
	$response->rows[$i]['request_id']=$row['request_id'];
	$response->rows[$i]['cell']=array($row['request_id'], $row['service_id'], $row['service_name'], $row['rq_date'], $row['rq_status'], $row['rq_pay']);
	$i++;
}
	echo json_encode($response);
	}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>