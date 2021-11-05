# TABLE USER
create or replace table users
(
    id         int auto_increment primary key,
    email      varchar(255) not null,
    name       varchar(255) not null,
    surname    varchar(255) not null,
    patronymic varchar(255) null,
    password   text         null,
    city       varchar(255) null,
    region     varchar(255) null,
    username   varchar(255) null,
    constraint email
        unique (email),
    constraint username
        unique (username)
);


SELECT COUNT(*) AS `Строки`, `username` FROM `users` GROUP BY `username` ORDER BY `username`

