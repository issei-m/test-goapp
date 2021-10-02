drop database if exists goapp;
create database goapp;
use goapp;
create table users(id bigint key auto_increment, email varchar(255) not null);
