create database mobile_drug_testing;

use mobile_drug_testing;

create table employees(
    id int primary key not null,
    first varchar(50) not null,
    last varchar(50) not null,
    addr1 varchar(100) not null,
    addr2 varchar(100),
    city varchar(50) not null,
    state varchar(2) not null,
    zip int(5) not null,
    ssn int(9) not null,
    dob date not null,
    active boolean
);

create table companies(
    id int primary key not null,
    company_name varchar(255) not null,
    addr1 varchar(100) not null,
    addr2 varchar(100),
    city varchar(50) not null,
    state varchar(2) not null,
    zip int(5) not null,
    company_phone int(10) not null,
    company_der varchar(100) not null,
    additional_phone int(10),
    email varchar(150) not null
);

create table test_type(
    id int primary key not null,
    name varchar(255) not null
);

create table tests(
    id int primary key not null,
    test_name varchar(255) not null,
    company varchar(255) not null,
    number_of_tests int(4) not null,
    number_bat_tests int(4),
    number_ua_tests int(4),
    technician_name varchar(100) not null,
    test_date date not null,
    rate decimal(10,2) not null,
    drive_time int(3),
    wait_time int(3),
    comments blob
);

create table login(
    user varchar(50) primary key not null, 
    pwd varchar(40) not null
);