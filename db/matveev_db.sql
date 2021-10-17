-- drop database if exists matveev_db;
-- create database matveev_db;
use matveev_db;

/* users - пользователи */

create table users (
user_id tinyint UNSIGNED NOT NULL auto_increment,
user_login varchar(16) NOT NULL,
user_password varchar(32) NOT NULL,
constraint pk_user primary key (user_id)
);

/* services - услуги */

create table services (
service_id tinyint(3) UNSIGNED NOT NULL auto_increment,
service_name varchar(20) NOT NULL,
service_cost decimal(8,2) UNSIGNED NOT NULL,
service_desc varchar(100),
constraint pk_service primary key (service_id)
)auto_increment=101;

/* clients - клиенты */

create table clients (
client_id smallint UNSIGNED NOT NULL auto_increment,
f_fio varchar(20) NOT NULL,
i_fio varchar(20) NOT NULL,
o_fio varchar(20) NOT NULL,
passport_num varchar(11) NOT NULL,
passport_date date NOT NULL,
passport_place varchar(100) NOT NULL,
tel varchar(12) NOT NULL,	
constraint pk_client primary key (client_id)
);

/* requests - заявки */

create table requests (
request_id smallint UNSIGNED NOT NULL auto_increment,
client_id smallint UNSIGNED NOT NULL,
service_id tinyint UNSIGNED NOT NULL,
contract_num smallint UNSIGNED NOT NULL,
rq_date date NOT NULL,
rq_status enum('Активна','Закрыта') NOT NULL,
rq_pay enum('Оплачена','Не оплачена') NOT NULL,
obj_sum decimal(10,2) UNSIGNED NOT NULL,
obj_rooms tinyint(1) UNSIGNED NOT NULL,
obj_size decimal(5,2) UNSIGNED NOT NULL,
obj_floor tinyint(2) UNSIGNED NOT NULL,
obj_floors tinyint(2) UNSIGNED NOT NULL,
obj_district enum('Верх-Исетский','Железнодорожный','Орджоникидзевский','Кировский','Октябрьский','Чкаловский','Ленинский') NOT NULL,
obj_address varchar(100),
rq_note varchar(1000),
constraint pk_request primary key (request_id),
constraint fk_client foreign key (client_id)
references clients (client_id),
constraint fk_service foreign key (service_id)
references services (service_id)
);

/* Данные */

/* Данные - пользователи */

insert into users
(user_id, user_login, user_password)
values (null, 'user1', 'b043d7e1e0a137a673135f7efa9de49c'),
(null, 'user157', '6c4b761a28b734fe93831e3fb400ce87');
/* user1 - 95425 user157 - 157 */

/* Данные - услуги */

insert into services
(service_id, service_name, service_cost, service_desc)
values (null, 'Покупка', 8000.00, 'Подбор объекта недвижимости для покупки'),
(null, 'Продажа', 10000.00, 'Подбор объекта недвижимости для продажи'),
(null, 'Найм', 2000.00, 'Подбор объекта недвижимости для найма (снять)'),
(null, 'Аренда', 4000.00, 'Подбор объекта недвижимости для аренды (сдать)');

/* Данные - клиенты */

insert into clients
(client_id, f_fio, i_fio, o_fio, passport_num, passport_date, passport_place, tel)
values (null, 'Борисов', 'Борис', 'Борисович', '6655 600500', '2005-05-15', 'г. Екатеринбург, ул. Боровая 19, кв. 40', '+79196065515'),
(null, 'Акимова', 'Анна', 'Альбертовна', '6650 650550', '2006-10-06', 'г. Екатеринбург, ул. Авиационная 16, кв. 32', '+79696065515'),
(null, 'Власова', 'Виктория', 'Витальевна', '6060 600600', '2006-06-06', 'г. Екатеринбург, ул. Щорса 82, кв. 61', '+79096066090'),
(null, 'Гришин', 'Григорий', 'Георгиевич', '6550 650560', '2008-02-12', 'г. Екатеринбург, ул. Блюхера 18, кв. 81', '+79656051516'),
(null, 'Власова', 'Виктория', 'Витальевна', '6060 600600', '2006-06-06', 'г. Екатеринбург, ул. Щорса 82, кв. 61', '+79096066090'),
(null, 'Самойлов', 'Степан', 'Сергеевич', '6363 520410', '1998-10-18', 'г. Екатеринбург, ул. Ясная 40, кв. 11', '+79906543322'),
(null, 'Тимофеева', 'Тамара', 'Терентьевна', '6556 330600', '2001-05-16', 'г. Екатеринбург, ул. Сулимова 46, кв. 22', '+79064506070'),
(null, 'Ишина', 'Ирина', 'Игоревна', '6260 420540', '2004-08-20', 'г. Екатеринбург, ул. Московская 71, кв. 14', '+79096066090');

/* Данные - заявки */

insert into requests
(request_id, client_id, service_id, contract_num, rq_date, rq_status, rq_pay, obj_sum, obj_rooms, obj_size, obj_floor, obj_floors, obj_district, obj_address, rq_note)
values (null, 1, 101, 1, '2016-06-16', 2, 1, 2000000.00, 1, 24.00, 4, 10, 5, 'Екатеринбург', 'Тестовая заявка'),
(null, 1, 102, 2, '2016-06-19', 1, 2, 2400000.00, 1, 24.00, 4, 10, 5, 'г. Екатеринбург, ул. Боровая 19, кв. 40', 'Тестовая заявка #2'),
(null, 2, 103, 3, '2016-06-26', 1, 1, 20000.00, 2, 32.00, 3, 9, 7, 'Екатеринбург', 'Тестовая заявка #3'),
(null, 3, 104, 4, '2016-06-26', 1, 1, 20000.00, 2, 32.00, 3, 9, 7, 'Екатеринбург', 'Тестовая заявка #4'),
(null, 5, 101, 5, '2016-10-10', 1, 1, 3000000.00, 3, 30.00, 5, 9, 5, 'Екатеринбург', 'Тестовая заявка #5'),
(null, 6, 101, 6, '2016-10-12', 1, 1, 3200000.00, 3, 32.00, 4, 10, 3, 'Екатеринбург', 'Тестовая заявка #6'),
(null, 7, 102, 7, '2016-10-16', 1, 1, 2800000.00, 2, 26.00, 7, 9, 4, 'г. Екатеринбург, ул. Сулимова 46, кв. 22', 'Тестовая заявка #7'),
(null, 8, 101, 8, '2016-10-20', 1, 2, 1700000.00, 1, 18.00, 2, 10, 6, 'Екатеринбург', 'Тестовая заявка #8');

/* Вывод данных */

-- select * from users;
-- select * from services;
-- select * from clients;
-- select * from requests;
