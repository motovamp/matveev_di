function fioCheck(value, colname) {
	var re = /^[а-яА-Я]{2,20}$/;
	if (re.test(value)) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите правильное имя"];
	}
}

function passport_numCheck(value, colname) {
	var re = /^\d{4}\s\d{6}$/;
	if (re.test(value)) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите правильный номер. Пример: 6655 444333"];
	}
}

function passport_placeCheck(value, colname) {
	if (value.length > 0 && value.length <= 100) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите место прописки"];
	}
}

function telCheck(value, colname) {
	let res = value.replace(/\D+/g, '');
	console.log(res);
	if (res.length == 11) {
		return [true,""];
	}
	else {
		return [false, colname+": Пожалуйста, введите правильный номер телефона. Пример: +7(999) 555-44-33"];
	}
}

function obj_addressCheck(value, colname) {
	if (value.length > 0 && value.length <= 100) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите адрес"];
	}
}

function rq_noteCheck(value, colname) {
	if (value.length > 0 && value.length <= 1000) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите примечание"];
	}
}

function service_nameCheck(value, colname) {
	var re = /^[а-яА-Я]{2,20}$/;
	if (re.test(value)) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите правильное название"];
	}
}

function service_descCheck(value, colname) {
	if (value.length > 0 && value.length <= 100) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите описание"];
	}
}
/* 16 символов */
/* function tel2check(value, colname) {
	var re = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
	if (re.test(value)) {
		return [true,""];
	}
	else {
		return [false,colname+": Пожалуйста, введите правильный номер телефона"];
	}
} */

/* function telcheck(value, colname) {
	if (value.length != 12) {	
		return [false,colname+": Пожалуйста, ведите правильный номер - +79997775533"];
	}
	else {
		return [true,""];
	}
}
function passportcheck(value, colname) {
	if (value.length != 11) {	
		return [false,colname+": Пожалуйста, ведите правильный номер - 6050 444333"];
	}
	else {
		return [true,""];
	}
} */