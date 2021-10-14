<?php
try{
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage= $_POST['rows'];
$sortingField= $_POST['sidx'];
$sortingOrder= $_POST['sord'];
//подключаемся к базе
include ("../connect.php");
/* $dbh = new PDO('mysql:host=localhost;dbname=nikulin_db','root', '157266');
$dbh->exec('SET CHARACTER SET utf8'); */

$qWhere='';

/* SEARCH */
if (isset($_POST['_search'])&&$_POST['_search']=='true'){
	$allowedFields=array('f_fio','i_fio','o_fio','passport_num','passport_date','passport_place','tel');
	$allowedOperations=array('AND', 'OR');

	$searchData= json_decode($_POST['filters']);
	
//ограничение на количество условий
if(count($searchData->rules) >10){
	throw new Exception('Cool hacker is here!:)');
	}
	$qWhere=' WHERE ';
	$firstElem=true;
	//все полученные условия вместе
	foreach($searchData->rules as $rule){
		if (!$firstElem){
		
		if(in_array($searchData->groupOp, $allowedOperations)){
			$qWhere .= ' '.$searchData->groupOp.' ';
		}
		else{
		throw new Exception('Cool hacker is here!:)');
		}
		}
	else{$firstElem = false;
	}
	//ставляем условия
	if(in_array($rule->field, $allowedFields)){
	switch($rule->op){
		case 'eq': $qWhere .= $rule->field.' = '.$dbh->quote($rule->data); break;
		case 'ne': $qWhere .= $rule->field.' <> '.$dbh->quote($rule->data); break;
		case 'bw': $qWhere .= $rule->field.' LIKE '.$dbh->quote($rule->data.'%'); break;
		case 'cn': $qWhere .= $rule->field.' LIKE '.$dbh->quote('%'.$rule->data.'%'); break;
		default: throw new Exception('Cool hacker is here!:)');
		}
	}
	else{
	//если получили не существующее условие
	throw new Exception('Cool hacker is here!:)');
	}
	}
	}
/* END OF SEARCH */		
//определяем количество записей в таблице
$rows = $dbh->query('SELECT COUNT(client_id) AS count FROM clients'.$qWhere);
$totalRows = $rows->fetch(PDO::FETCH_ASSOC);
$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;
//получаем список пользователей из базы
$res = $dbh->query('SELECT * FROM  clients'.$qWhere.' ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response->page =  $curPage;
$response->total = ceil($totalRows['count'] / $rowsPerPage);
$response->records = $totalRows['count'];

$i=0;
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