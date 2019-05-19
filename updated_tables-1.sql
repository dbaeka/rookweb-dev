create table categories
(
	id int auto_increment,
	title varchar(100) not null,
	constraint categories_id_uindex
		unique (id)
)
;

alter table categories
	add primary key (id)
;

create table internships
(
	id int auto_increment,
	location varchar(100) not null,
	type enum('free', 'paid') not null,
	title varchar(150) not null,
	deadline date not null,
	comapny_id int not null,
	category_id int not null,
	constraint internships_id_uindex
		unique (id)
)
;

alter table internships
	add primary key (id)
;

create table student_internships
(
	id int auto_increment,
	user_id int not null,
	internship_id int not null,
	is_applied tinyint(1) default 0 not null,
	constraint student_internships_id_uindex
		unique (id)
)
;

alter table student_internships
	add primary key (id)
;

INSERT INTO myrooker_develDB.categories (id, title) VALUES (1, 'Technology');
INSERT INTO myrooker_develDB.categories (id, title) VALUES (2, 'Design');

INSERT INTO myrooker_develDB.internships (id, location, type, title, deadline, comapny_id, category_id) VALUES (1, 'Accra, Ghana', 'paid', 'Software Engineer Intern', '2020-06-16', 6, 1);
INSERT INTO myrooker_develDB.internships (id, location, type, title, deadline, comapny_id, category_id) VALUES (2, 'East Legon', 'free', 'Graphic Designer', '2020-04-23', 9, 2);

INSERT INTO myrooker_develDB.student_internships (id, user_id, internship_id, is_applied) VALUES (1, 752, 1, 1);