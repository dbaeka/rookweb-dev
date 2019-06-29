USE devel_db
create table if not exists article_logs
(
    id int auto_increment,
    article_id int not null,
    student_id int not null,
    timepost datetime not null,
    interested enum('yes', 'no') null,
    viewed tinyint(1) null,
    constraint article_logs_id_uindex
        unique (id)
);

alter table article_logs
    add primary key (id);

create table if not exists articles
(
    id int auto_increment,
    title varchar(100) not null,
    timepost datetime not null,
    category_id int not null,
    company_id int not null,
    views int null,
    link varchar(200) not null,
    constraint articles_id_uindex
        unique (id)
);

alter table articles
    add primary key (id);

create table if not exists event_logs
(
    id int auto_increment,
    article_id int not null,
    student_id int not null,
    timepost datetime not null,
    interested enum('yes', 'no', 'maybe') null,
    viewed tinyint(1) null,
    constraint event_logs_id_uindex
        unique (id)
);

alter table event_logs
    add primary key (id);

create table if not exists events
(
    id int auto_increment,
    title varchar(100) not null,
    image varchar(200) null,
    price int null,
    timepost datetime not null,
    location varchar(100) null,
    event_date datetime null,
    details varchar(200) null,
    company_id int not null,
    category_id int null,
    constraint events_id_uindex
        unique (id)
);

alter table events
    add primary key (id);

create table if not exists poll_results
(
    id int auto_increment,
    poll_id int not null,
    student_id int not null,
    timepost datetime not null,
    type enum('2', '3', '4', '5', '6', '7', '8', '9', '10') not null,
    result_1 int null,
    result_2 int null,
    result_3 int null,
    result_4 int null,
    result_5 int null,
    result_6 int null,
    result_7 int null,
    result_8 int null,
    result_9 int null,
    constraint poll_results_id_uindex
        unique (id)
);

alter table poll_results
    add primary key (id);

create table if not exists polls
(
    id int auto_increment,
    title varchar(100) not null,
    company_id int not null,
    timepost datetime not null,
    constraint polls_id_uindex
        unique (id)
);

alter table polls
    add primary key (id);

create table if not exists video_logs
(
    id int auto_increment,
    video_id int not null,
    student_id int not null,
    timepost datetime not null,
    interested enum('yes', 'no') null,
    viewed tinyint(1) null,
    constraint video_logs_id_uindex
        unique (id)
);

alter table video_logs
    add primary key (id);

create table if not exists videos
(
    id int auto_increment,
    title varchar(100) not null,
    timepost datetime not null,
    views int null,
    category_id int not null,
    company_id int not null,
    constraint videos_id_uindex
        unique (id)
);

alter table videos
    add primary key (id);

