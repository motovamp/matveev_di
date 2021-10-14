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
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="../css/searchFilter.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../js/plugins/searchFilter.css"> -->
	<link rel="stylesheet" type="text/css" media="screen" href="../css/ui.jqgrid.css">
<!-- JS //-->
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/i18n/grid.locale-ru.js"></script>
	<!-- <script type="text/javascript" src="../js/jquery.searchFilter.js"></script>
	<script type="text/javascript" src="../js/plugins/jquery.searchFilter.js"></script> -->
	<script type="text/javascript" src="../js/jquery.jqGrid.min.js"></script>
	<!-- <script type="text/javascript" src="../js/jquery.searchFilter.js"></script>
	<script type="text/javascript" src="../js/plugins/jquery.searchFilter.js"></script> -->
	<!-- <script type="text/javascript" src="../js/grid.addons.js"></script> -->
	<!-- <script type="text/javascript" src="../js/jquery.searchFilter.js"></script>
	<script type="text/javascript" src="../js/plugins/jquery.searchFilter.js"></script> -->
	
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
<!-- GRID CODE //-->
			<script>
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
			//jQuery("#jqGrid").jqGrid('filterToolbar',{searchOperators:true});
		
			});
						
			
			</script>
		</div>
	</div>
</body>
</html>