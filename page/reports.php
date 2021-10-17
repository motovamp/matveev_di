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
	<script type="text/javascript" src="../js/jquery-ui.js"></script>	
	<script type="text/javascript" src="../js/inputCheck.js"></script>
	<title>Отчеты</title>

	<style type="text/css">
		.hasDatepicker {
			border-radius: 6px;
			width: 80px;
		}
	</style>
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
			<span>Начало периода</span><input id="start_p" value="<?=date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')))?>">
			&nbsp;&nbsp; - &nbsp;&nbsp;
			<span>Конец периода</span><input id="end_p" value="<?=date('Y-m-d')?>">
			<button onclick="reload()">Сформировать</button>
<!-- GRID CODE //-->
			<script>

				function reload() {
					let start = $('#start_p').val(), end = $('#end_p').val();
					$("#jqGrid").jqGrid('setGridParam',{url: `../php/reports/getdata.php?start=${start}&end=${end}`, page:1}).trigger("reloadGrid")
				}
				

				$(document).ready(function(){
					var lastSel;
					var services;
					var clients;

					$.ajax({
						url: '../php/requests/additional.php',
						dataType: 'json',
						method: 'POST',
						success: function(data) {
							if(data?.services) services = data.services.join(';');
							if(data?.clients) clients = data.clients.join(';');


							$("#jqGrid").jqGrid( {
								url:'../php/reports/getdata.php',
								datatype: 'json',
								mtype: 'POST',
								colModel :[
									{label:'ID', name:'request_id', key:true, width:50, search:false},
									/* {label:'IDКлиента', name:'client_id', width:50, editable:false, search:false, hidden:true}, */
									{label:'IDУслуги', name:'service_id', width:50, editable:false, search:false, hidden:true},
									
									
									
									/* из услуг */
									{label:'Наименование', name:'service_name', width:100, search: false,  editable:false, edittype:"select", stype: 'select', editoptions:{value: services}, searchoptions:{sopt:['eq','ne','bw','cn']}},
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
							
							/* Локализация datepicker */
							$.datepicker.regional['ru'] = {
								closeText: 'Закрыть',
								prevText: 'Предыдущий',
								nextText: 'Следующий',
								currentText: 'Сегодня',
								monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
								monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
								dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
								dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
								dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
								weekHeader: 'Не',
								dateFormat: 'yy-mm-dd',
								firstDay: 1,
								isRTL: false,
								showMonthAfterYear: false,
								yearSuffix: ''
							};
							$.datepicker.setDefaults($.datepicker.regional['ru']);
							$.datepicker.setDefaults({changeYear: true});

							$('#start_p').datepicker();
							$('#end_p').datepicker();

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
									let start = $('#start_p').val(), end = $('#end_p').val();
									window.location.href = `../php/reports/report.php?start=${start}&end=${end}`;
									
									// конец обработчика кнопки
								},
								position:"first",
								title:"Сформировать печатную версию",
							});

							// $("#jqGrid").jqGrid('filterToolbar',{searchOperators:true});

						}
					})
				});
			</script>
		</div>
	</div>
</body>
</html>