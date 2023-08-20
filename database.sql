create database if not exists api;

use api;

create table if not exists users (
  id int(11) not null primary key auto_increment,
  name varchar(255) not null,
  email varchar(255) not null,
  passwd varchar(255) not null
);

create table if not exists books (
  id int(11) not null primary key auto_increment,
  title varchar (155) not null,
  year_created YEAR not null,
  user_id int(11) not null,
  foreign key (user_id) references users (id)
);
