<?php
try{
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage= $_POST['rows'];
$sortingField= 'clients.'.$_POST['sidx'];
$sortingOrder= $_POST['sord'];

// die(print_r($_GET, true));

$filtered = !isset($_GET['filtered']) || $_GET['filtered'] == 1;
//подключаемся к базе
include ("../connect.php");

$qWhere='';

/* SEARCH */
if ($filtered || (isset($_POST['_search'])&&$_POST['_search']=='true')) {
	$allowedFields=array('f_fio','i_fio','o_fio','passport_num','passport_date','passport_place','tel');
	$allowedOperations=array('AND', 'OR');

	$searchData = isset($_POST['_search']) && $_POST['_search'] == 'true' && isset($_POST['filters']) ? json_decode($_POST['filters']) : false;
	
	//ограничение на количество условий
	if(count($searchData->rules) > 10){
		throw new Exception('Cool hacker is here!:)');
	}

	$qWhere=' WHERE ';

	if($filtered) {
		$qWhere .= "client_id not in (SELECT `requests`.client_id from requests where requests.rq_status = 'Закрыта' GROUP BY client_id EXCEPT 
		(SELECT `requests`.client_id from requests where requests.rq_status <> 'Закрыта' GROUP BY client_id)) ";
	}

	$firstElem=true;
	//все полученные условия вместе
	if($searchData) foreach($searchData->rules as $rule) {
		if (!$firstElem) {
		
			if(in_array($searchData->groupOp, $allowedOperations)){
				$qWhere .= ' '.$searchData->groupOp.' ';
			} else {
				throw new Exception('Cool hacker is here!:)');
			}
		} else {$firstElem = false;}
		//ставляем условия
		if(in_array($rule->field, $allowedFields)) {
				switch($rule->op) {
					case 'eq': $qWhere .= 'clients.'.$rule->field.' = '.$dbh->quote($rule->data); break;
					case 'ne': $qWhere .= 'clients.'.$rule->field.' <> '.$dbh->quote($rule->data); break;
					case 'bw': $qWhere .= 'clients.'.$rule->field.' LIKE '.$dbh->quote($rule->data.'%'); break;
					case 'cn': $qWhere .= 'clients.'.$rule->field.' LIKE '.$dbh->quote('%'.$rule->data.'%'); break;
					default: throw new Exception('Cool hacker is here!:)');
				}
			} else {
			//если получили не существующее условие
			throw new Exception('Cool hacker is here!:)');
		}
	}
}
/* END OF SEARCH */		
//определяем количество записей в таблице

$req = 'SELECT clients.* FROM  clients'.$qWhere;

$rows = $dbh->query($req);
$totalRows = $rows->fetch(PDO::FETCH_ASSOC);
$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;
//получаем список пользователей из базы
$res = $dbh->query($req.' ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage);
//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response->page =  $curPage;
$response->total = ceil($totalRows['count'] / $rowsPerPage);
$response->records = $totalRows['count'];

$i=0;

// die(json_encode($res->fetchAll()));

while($row = $res->fetch(PDO::FETCH_ASSOC)){
	$response->rows[$i]['client_id']=$row['client_id'];
	$response->rows[$i]['cell']=array(/*'', */$row['client_id'], $row['f_fio'], $row['i_fio'], $row['o_fio'],$row['passport_num'], $row['passport_date'], $row['passport_place'], $row['tel']);
	$i++;
}
	echo json_encode($response);
	}
catch(PDOException $e){
echo 'Database error: '.$e->getMessage();
}
?>