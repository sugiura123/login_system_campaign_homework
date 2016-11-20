
create database test1;

use test1;

grant all on test1.* to testuser@localhost identified by '9999';


create table campaign (
id int(11) primary key auto_increment,
name varchar(32),
email varchar(32),
number int(11),
address varchar(32),
password varchar(32),
result int
);