create database mobile_drug_testing;

use mobile_drug_testing;
drop table employees;
create table employees(
    id int primary key not null auto_increment,
    first varchar(50) not null,
    last varchar(50) not null,
    addr1 varchar(100) not null,
    addr2 varchar(100),
    city varchar(50) not null,
    state varchar(2) not null,
    zip int(5) not null,
    phone varchar(12) not null,
    email varchar(150) not null,
    ssn varchar(11) not null,
    dob date not null,
    active boolean default true
);

create table companies(
    id int primary key not null auto_increment,
    company_name varchar(255) not null,
    addr1 varchar(100) not null,
    addr2 varchar(100),
    city varchar(50) not null,
    state varchar(2) not null,
    zip int(5) not null,
    company_phone varchar(12) not null,
    company_der varchar(100) not null,
    additional_phone varchar(12),
    email varchar(150) not null,
    active boolean not null default true
);

create table test_types(
    id int primary key not null auto_increment,
    name varchar(255) not null,
    active boolean not null default true
);

create table tests(
    id int primary key not null auto_increment,
    test_name varchar(255) not null,
    company varchar(255) not null,
    number_of_tests int(4) not null,
    number_bat_tests int(4),
    number_ua_tests int(4),
    tech_id int not null,
    test_date date not null,
    rate decimal(10,2) not null,
    drive_time int(3),
    wait_time int(3),
    comments blob,
    active boolean not null default true
);

create table login(
    user varchar(50) primary key not null, 
    pwd varchar(40) not null
);