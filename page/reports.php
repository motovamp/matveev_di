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
	
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="../css/searchFilter.css"> -->
<!-- JS //-->
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/i18n/grid.locale-ru.js"></script>
	<script type="text/javascript" src="../js/jquery.jqGrid.min.js"></script>
	
	<script type="text/javascript" src="../js/inputCheck.js"></script>
	<!-- <script type="text/javascript" src="../js/grid.addons.js"></script>
	<script type="text/javascript" src="../js/jquery.searchFilter.js"></script> -->
	<title>Отчеты</title>
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
			<li id="menu_btn"><a id="menu_link" href="services.php">Услуги</a></li>
			<li id="menu_btn"><a id="menu_alink" href="reports.php">Отчеты</a></li>
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
				url:'../php/reports/getdata.php',
				datatype: 'json',
				mtype: 'POST',
				colModel :[
					{label:'ID', name:'request_id', key:true, width:50, search:false},
					/* {label:'IDКлиента', name:'client_id', width:50, editable:false, search:false, hidden:true}, */
					{label:'IDУслуги', name:'service_id', width:50, editable:false, search:false, hidden:true},
					
					
					
					/* из услуг */
					{label:'Наименование', name:'service_name', width:100, editable:false, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}},
					/* конец услуг */
					
					/* {label:'Договор', name:'contract_num', width:50, editable:false, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}, */
					{label:'Дата заключения', name:'rq_date', width:100, editable:false, edittype:"text", editrules:{required:true, date:true}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Статус', name:'rq_status', width:100, editable:false, edittype:'select', stype:'select', editoptions:{value:"1:Активна;2:Закрыта"}, searchoptions:{sopt:['eq'],  value:"Активна:Активна;Закрыта:Закрыта"}},
					{label:'Оплата', name:'rq_pay', width:100, editable:false, edittype:'select', stype:'select', editoptions:{value:"1:Оплачена;2:Не оплачена"}, searchoptions:{sopt:['eq'],  value:"Оплачена:Оплачена;Не оплачена:Не оплачена"}},
					
				],
				
				autowidth:true,
				//width:1200,
				height:"100%",
				
				/* shrinkToFit:1800, */ /* it's a magic! */
								
				pager:'#jqGridPager',
				rowNum:10,
				rowList:[10,20,30],
				sortname:'request_id',
				sortorder:"asc",
				viewrecords:true,
				editurl:"../php/reports/load.php",
				caption:'Отчеты о заявках за последний месяц',
				
				/* ondblClickRow: function(request_id) {
					if (request_id && request_id !== lastSel) {
						$("#jqGrid").restoreRow(lastSel);
						$("#jqGrid").editRow(request_id, true);
						lastSel = request_id;
				   }
				} */	
			});
			
			$("#jqGrid").jqGrid('navGrid','#jqGridPager',{edit:false,add:false,del:false,search:false},
			{
				/* EDIT */
				closeAfterEdit: true,
				url: "../php/reports/load.php",
				reloadAfterSubmit: true,
				bSubmit: "Сохранить",
				savekey:[true,13],
				navkeys:[true,38,40]
			},
		
			{
				/* ADD */
				closeAfterAdd: true,
				url: "../php/reports/add.php",
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
				url: '../php/reports/delete.php',
				reloadAfterSubmit: true,
				mtype: "POST"
			},
		
			{
				/* SEARCH */
				closeOnEscape: true,
				multipleSearch: true,
				closeAfterSearch: true
			}
			).jqGrid('navSeparatorAdd','#jqGridPager',{position:"first"}).jqGrid('navButtonAdd','#jqGridPager',{
				caption:"",
				buttonicon:"ui-icon-print",
				onClickButton: function(){
					// обработчик кнопки формирования договора
					//выбираем строку
					var selectedRowId = $('#jqGrid').jqGrid('getGridParam','selrow'),
					//получаем значение ID
					idValue = $('#jqGrid').jqGrid('getCell',selectedRowId,'request_id');
					
					window.location.href = '../php/reports/report.php';
					
					// конец обработчика кнопки
				},
				position:"first",
				title:"Сформировать печатную версию",
			});
		
		
			});
			</script>
		</div>
	</div>
</body>
</html>