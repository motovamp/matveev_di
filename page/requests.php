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
	<script type="text/javascript" src="../js/imask.js"></script>	
	<script type="text/javascript" src="../js/inputCheck.js"></script>
	<title>БД "Заявки"</title>
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
			<li id="menu_btn"><a id="menu_alink" href="requests.php">Заявки</a></li>
			<li id="menu_btn"><a id="menu_link" href="services.php">Услуги</a></li>
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
					var services;
					var clients;

					$.ajax({
						url: '../php/requests/additional.php',
						dataType: 'json',
						method: 'POST',
						success: function(data) {
							if(data?.services) services = data.services.join(';');
							if(data?.clients) clients = data.clients.join(';');

							$(document).ready(function() {
								var lastSel;
								$("#jqGrid").jqGrid( {
									url:'../php/requests/getdata.php',
									datatype: 'json',
									mtype: 'POST',
									colModel :[
										{label:'ID', name:'request_id', key:true, width:50, search:false},
										{label:'Клиент', name:'client_id', width:50, editable:true, search:false, hidden:true, edittype:"select", stype: 'select', editoptions:{value: clients}, editrules:{edithidden:true}},
										{label:'Услуга', name:'service_id', width:50, editable:true, search:false, hidden:true, edittype:"select", stype: 'select', editoptions:{value: services}, editrules:{edithidden:true}},
										{label:'Вид недвижимости', name:'re_type', width: 70, editable:true, search:false, hidden:false, edittype:"select", stype: 'select', editoptions:{value: 'Жилая:Жилая;Не жилая:Не жилая'}, editrules:{edithidden:true}},
										
										/* из клиентов */
										{label:'Фамилия', name:'f_fio', width:100, editable:false, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Имя', name:'i_fio', width:100, editable:false, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Отчество', name:'o_fio', width:100, editable:false, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										/* конец клиентов */
										
										/* из услуг */
										{label:'Наименование', name:'service_name', width:100, editable:false, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}},
										/* конец услуг */
										
										{label:'Договор', name:'contract_num', width:50, editable:false, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Дата заключения', name:'rq_date', width:100, editable:true, edittype:"text", editrules:{required:true, date:true}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Статус', name:'rq_status', width:100, editable:true, edittype:'select', stype:'select', editoptions:{value:"1:Активна;2:Закрыта"}, searchoptions:{sopt:['eq'],  value:"Активна:Активна;Закрыта:Закрыта"}},
										{label:'Оплата', name:'rq_pay', width:100, editable:true, edittype:'select', stype:'select', editoptions:{value:"1:Оплачена;2:Не оплачена"}, searchoptions:{sopt:['eq'],  value:"Оплачена:Оплачена;Не оплачена:Не оплачена"}},
										
										{label:'Сумма', name:'obj_sum', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, minValue:1, maxValue:99999999}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Комнаты', name:'obj_rooms', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, integer:true, minValue:1, maxValue:9}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Метраж', name:'obj_size', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, minValue:1, maxValue:999}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Этаж', name:'obj_floor', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, integer:true, minValue:1, maxValue:99}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										{label:'Этажность', name:'obj_floors', width:100, editable:true, edittype:"text", editrules:{required:true, number:true, integer:true, minValue:1, maxValue:99}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										
										{label:'Район', name:'obj_district', width:100, editable:true, edittype:'select', stype:'select', editoptions:{value:"1:Верх-Исетский;2:Железнодорожный;3:Орджоникидзевский;4:Кировский;5:Октябрьский;6:Чкаловский;7:Ленинский"}, searchoptions:{sopt:['eq'],  value:"Верх-Исетский:Верх-Исетский;Железнодорожный:Железнодорожный;Орджоникидзевский:Орджоникидзевский;Кировский:Кировский;Октябрьский:Октябрьский;Чкаловский:Чкаловский;Ленинский:Ленинский"}},
										{label:'Адрес', name:'obj_address', width:100, editable:true, edittype:"text", editrules:{required:false, custom:true, custom_func:obj_addressCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
										
										{label:'Примечание', name:'rq_note', width:200, editable:true, edittype:"text", editrules:{required:false, custom:true, custom_func:rq_noteCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
									],
									
									autowidth:true,
									//width:1200,
									height:"100%",
									
									shrinkToFit:1800, /* it's a magic! */
													
									pager:'#jqGridPager',
									rowNum:10,
									rowList:[10,20,30],
									sortname:'request_id',
									sortorder:"asc",
									viewrecords:true,
									editurl:"../php/requests/load.php",
									caption:'База данных "Заявки"',
									
									ondblClickRow: function(request_id) {
										if (request_id && request_id !== lastSel) {
											$("#jqGrid").restoreRow(lastSel);
											$("#jqGrid").editRow(request_id, true);
											lastSel = request_id;
									}
									}
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

								// --> Mutation observer for mask edit and calendar
								function mutaCb(records) {
									records.forEach(function (record) {
										let list = record.addedNodes;					
										for (let i = list.length - 1; i > -1; i-- ) {
											if (list[i].id == "editmodjqGrid") {
												let container = list[i];

												let element = container.querySelector('#obj_sum:not(.masked)');
												if(element) { 
													IMask(element, {mask: Number, min: 0, csale: 0, radix: '.'})
												}

												element = container.querySelector('#obj_rooms:not(.masked)');
												if(element) { 
													IMask(element, {mask: Number, min: 0, max: 100, csale: 0})
												}
												
												element = container.querySelector('#obj_size:not(.masked)');
												if(element) { 
													IMask(element, {mask: Number, min: 0, max: 10000, csale: 0})
												}
												
												element = container.querySelector('#obj_floor:not(.masked)');
												if(element) { 
													IMask(element, {mask: Number, min: 0, max: 200, csale: 0})
												}
												
												element = container.querySelector('#obj_floors:not(.masked)');
												if(element) { 
													IMask(element, {mask: Number, min: 0, max: 200, csale: 0})
												}
												
												element = container.querySelector('#rq_date');
												if(element) { 
													console.log('test');
													$(element).datepicker()	
												}
											}
										}
									});
								}

								const observer = new MutationObserver(mutaCb);
								observer.observe(document.body, { childList: true, subtree: true });
								// -----------------------
								$("#jqGrid").jqGrid('navGrid','#jqGridPager',{edit:true,add:true,del:true,search:true},
								{
									/* EDIT */
									closeAfterEdit: true,
									url: "../php/requests/load.php",
									reloadAfterSubmit: true,
									bSubmit: "Сохранить",
									savekey:[true,13],
									navkeys:[true,38,40]
								},
							
								{
									/* ADD */
									closeAfterAdd: true,
									url: "../php/requests/add.php",
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
									url: '../php/requests/delete.php',
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
									buttonicon:"ui-icon-document",
									onClickButton: function(){
										// обработчик кнопки формирования договора
										//выбираем строку
										var selectedRowId = $('#jqGrid').jqGrid('getGridParam','selrow'),
										//получаем значение ID
										idValue = $('#jqGrid').jqGrid('getCell',selectedRowId,'request_id');
										//если значение пусто, то выводим ошибку
										if(!idValue){
											alert('Выберете заявку для формирования договора');
										}
										//иначе отправляем значение в php-обработчик
										else{
											//$.post("../php/contracts/contract_card.php",{id:idValue});
											window.location.href = '../php/contracts/contract.php?id='+idValue;
										}
										// конец обработчика кнопки
									},
									position:"first",
									title:"Сформировать договор",
								});
							})
						}
					});
			</script>
		</div>
	</div>
</body>
</html>