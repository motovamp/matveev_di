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
	location.replace("login.php");
	</script>';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
<!-- CSS //-->
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/ui.jqgrid.css">
<!-- JS //-->
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/i18n/grid.locale-ru.js"></script>
	<script type="text/javascript" src="../js/jquery.jqGrid.min.js"></script>
	
	<script type="text/javascript" src="../js/inputCheck.js"></script>
	<title>БД "Услуги"</title>
</head>
<body>
<!-- Навигация //-->
	<div id="navigation">
<!-- LOGO //-->
		<!-- <div id="logo"></div> -->
<!-- MENU //-->
		<ul id="menu">
			<li id="menu_index_btn"><a id="menu_link" href="../index.php">Главная</a></li>
			<li id="menu_btn"><a id="menu_link" href="clients.php">Клиенты</a></li>
			<li id="menu_btn"><a id="menu_link" href="requests.php">Заявки</a></li>
			<li id="menu_btn"><a id="menu_alink" href="services.php">Услуги</a></li>
			<li id="menu_btn"><a id="menu_link" href="reports.php">Отчеты</a></li>
			<li id="menu_exit_btn"><a id="menu_link" href="../php/auth/exit.php">Выход</a></li>
		</ul>
	</div>
<!-- Контент //-->
	<div id="content">
		<div id="content_inner" align="center">
<!-- GRID TABLE //-->			
			<table id="jqGrid"></table>
			<div id="jqGridPager"></div>
<!-- GRID CODE //-->
			<script>
			$(document).ready(function(){
			var lastSel;
			$("#jqGrid").jqGrid( {
				url:'../php/services/getdata.php',
				datatype: 'json',
				mtype: 'POST',
				colModel :[
					{label:'ID', name:'service_id', key:true, width:50, search:false},
					{label:'Наименование', name:'service_name', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:service_nameCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Стоимость', name:'service_cost', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, minValue:1, maxValue:999999}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Описание', name:'service_desc', width:250, editable:true, edittype:"text", editrules:{required:false, custom:true, custom_func:service_descCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
				],
				
				autowidth:true,
				//width:1000,
				height:"100%",
				
				pager:'#jqGridPager',
				rowNum:10,
				rowList:[10,20,30],
				sortname:'service_id',
				sortorder:"asc",
				viewrecords:true,
				editurl:"../php/services/load.php",
				caption:'База данных "Услуги"',
				
				ondblClickRow: function(service_id) {
					if (service_id && service_id !== lastSel) {
						$("#jqGrid").restoreRow(lastSel);
						$("#jqGrid").editRow(service_id, true);
						lastSel = service_id;
				   }
				}
			});
			
			$("#jqGrid").jqGrid('navGrid','#jqGridPager',{edit:true,add:true,del:true,search:true},
			{
				/* EDIT */
				closeAfterEdit: true,
				url: "../php/services/load.php",
				reloadAfterSubmit: true,
				bSubmit: "Сохранить",
				savekey:[true,13],
				navkeys:[true,38,40]
			},
		
			{
				/* ADD */
				closeAfterAdd: true,
				url: "../php/services/add.php",
				reloadAfterSubmit: true,
				bSubmit: "Сохранить",
				bCancel: "Отменить",
				savekey:[true,13]
			},
		
			{
				/* DEL */
				msg: "Удалить запись?",
				bSubmit: "Удалить",
				bCancel: "Отменить",
				url: '../php/services/delete.php',
				reloadAfterSubmit: true,
				mtype: "POST"
			},
		
			{
				/* SEARCH */
				closeOnEscape: true,
				multipleSearch: true,
				closeAfterSearch: true}
			);
		
		
			});
			</script>
		</div>
	</div>
</body>
</html>