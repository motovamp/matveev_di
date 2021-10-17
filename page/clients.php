<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
// если не получен ID сессии
// перенаправляем на страницу авторизации
if (!isset($_SESSION['id'])) {
	header("Location: /page/login.php");
	exit();
} ?>
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
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/imask.js"></script>	
	<script type="text/javascript" src="../js/inputCheck.js"></script>
	<title>БД "Клиенты"</title>
</head>
<body>
<!-- Навигация //-->
	<div id="navigation">
<!-- LOGO //-->
		<!-- <div id="logo"></div> -->
<!-- MENU //-->
		<ul id="menu">
			<li id="menu_index_btn"><a id="menu_link" href="../index.php">Главная</a></li>
			<li id="menu_btn"><a id="menu_alink" href="clients.php">Клиенты</a></li>
			<li id="menu_btn"><a id="menu_link" href="requests.php">Заявки</a></li>
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
			<input type="checkbox" id="fcheck" style="cursor: pointer;" onclick="reload()">
			<span onclick="reload(true)" style="cursor: pointer;">Показывать всех</span>
			<script type="text/javascript">
				var filtered = 0;
				function reload(change) {
					if(change) {
						$("#fcheck").prop('checked', !$('#fcheck').is(':checked'))
					}
					filtered = $('#fcheck').is(':checked') ? 0 : 1;

					$("#jqGrid").jqGrid('setGridParam',{url: "../php/clients/getdata.php?filtered=" + filtered, page:1}).trigger("reloadGrid")
				}
			
			$(document).ready(function(){
			var lastSel;
			
			$("#jqGrid").jqGrid( {
				url:'../php/clients/getdata.php',
				datatype: 'json',
				mtype: 'POST',
				colModel :[
					/* колонка для кнопок */
					//{label:'Действие', name:'action', index:'action', width:50, editable:false, sortable:false, search:false},
					/* основные колонки с данными */
					{label:'ID', name:'client_id', key:true, width:50, search:false},
					{label:'Фамилия', name:'f_fio', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Имя', name:'i_fio', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Отчество', name:'o_fio', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:fioCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Паспорт', name:'passport_num', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:passport_numCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Дата выдачи', name:'passport_date', width:100, editable:true, edittype:"text", editrules:{required:true, date:true}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Прописка', name:'passport_place', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:passport_placeCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
					{label:'Телефон', name:'tel', width:100, editable:true, edittype:"text", editrules:{required:true, custom:true, custom_func:telCheck}, searchoptions:{sopt:['eq','ne','bw','cn']}},
				],
				
				autowidth:true, //it's a magic
				//width:1000,
				height:"100%",
				
				pager:'#jqGridPager',
				rowNum:10,
				rowList:[10,20,30],
				sortname:'client_id',
				sortorder:"asc",
				viewrecords: true,
				editurl:"../php/clients/load.php",
				caption:'База данных "Клиенты"',
				
				/* костыльный код колонки с кнопками */
				
				/*gridComplete: function(){
					var ids = jQuery("#jqGrid").jqGrid('getDataIDs');
					for(var i=0;i < ids.length;i++){
						var cl = ids[i];
						ie = "<input style='height:22px;width:25px;' type='button' value='i' title='Информация' onclick=\"alert('Заглушка инфо клиента');\" />"; 
						//se = "<input style='height:22px;width:25px;' type='button' value='S' onclick=\"\" />"; 
						//ce = "<input style='height:22px;width:25px;' type='button' value='C' onclick=\"\" />";
						jQuery("#jqGrid").jqGrid('setRowData',ids[i],{action:ie});
					}	
				},*/
								
				/* конец костыля с кнопками */
				
				ondblClickRow: function(client_id) {
					if (client_id && client_id !== lastSel) {
						$("#jqGrid").restoreRow(lastSel);
						$("#jqGrid").editRow(client_id, true);
						lastSel = client_id;
				   }
				}
			});

			// --> COOKIE

			function setCookie(name, value, options) {
				options = options || {};
				var expires = options.expires;
			
				if (typeof expires == "number" && expires) {
					var d = new Date();
					d.setTime(d.getTime() + expires * 1000);
					expires = options.expires = d;
				}
				if (expires && expires.toUTCString) {
					options.expires = expires.toUTCString();
				}
			
				value = encodeURIComponent(value);
			
				var updatedCookie = name + "=" + value;
			
				for (var propName in options) {
					updatedCookie += "; " + propName;
					var propValue = options[propName];
					if (propValue !== true) updatedCookie += "=" + propValue;
				}
				document.cookie = updatedCookie;
			}

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

							let element = container.querySelector('#passport_num:not(.masked)');
							if(element) { 
								IMask(element, {mask: '0000 000000', lazy: false})
							}

							element = container.querySelector('#tel:not(.masked)');
							if(element) { 
								IMask(element, {mask: '+{7}(000) 000-00-00', lazy: false})
							}
							
							element = container.querySelector('#passport_date');
							if(element) { 
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
				url: "../php/clients/load.php",
				reloadAfterSubmit: true,
				bSubmit: "Сохранить",
				savekey:[true,13],
				navkeys:[true,38,40]				
			},
		
			{
				/* ADD */
				closeAfterAdd: true,
				url: "../php/clients/add.php",
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
				url: '../php/clients/delete.php',
				reloadAfterSubmit: true,
				mtype: "POST"
			},
		
			{
				/* SEARCH */
				closeOnEscape: true,
				multipleSearch: true,
				closeAfterSearch: true

			}
			);
			
			// поиск по колонкам
			// $("#jqGrid").jqGrid('filterToolbar',{searchOperators:true});
			
		
			});
						
			
			</script>
		</div>
	</div>
</body>
</html>