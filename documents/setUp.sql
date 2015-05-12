create database mobile_drug_testing;

use mobile_drug_testing;
SELECT first, last, phone, email, active FROM employees WHERE email='joelgrissom5@gmail.com';
create table employees(
    id int unsigned primary key not null auto_increment,
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
	bat_id int not null,
    active boolean default true
);

create table companies(
    id int unsigned primary key not null auto_increment,
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
    id int unsigned primary key not null auto_increment,
    name varchar(255) not null,
    active boolean not null default true
);

insert into test_types (name) values (
'No Show / Cancel'
'Pre-employment'
'Random_BAT'
'Random_UA'
'Post Accident'
'Reasonable Suspicion'
'Follow Up'
'Return to Duty'
'Other'
);

create table tests(
    id int unsigned primary key not null auto_increment,
    test_name varchar(255) not null,
    company varchar(255) not null,
    number_of_tests int(4) not null,
    tech_id int not null,
    test_date date not null,
    comments blob,
    rate_type varchar(10) not null,
    num_hours int,
    base_fee decimal(8,2) not null,
    additional_test_fee decimal(8,2),
    fuel_fee decimal(8,2),
    pager_fee decimal(8,2),
    wait_fee decimal(8,2),
    drive_time_fee decimal(8,2),
    admin_fee decimal(8,2),
    training_fee decimal(8,2),
    holiday_fee decimal(8,2),
    misc_fee decimal(8,2),
    active boolean not null default true
);
select * from login;
UPDATE login SET active=0 WHERE email='joelgrissom5@gmail.com';
create table login(
	user_id int auto_increment primary key,
    user varchar(50) not null, 
    pwd varchar(255) not null,
    email varchar(150) not null,
    active boolean default false not null
);

-- time_records is NOT implemented. . . fields added to tests table
create table time_records(
	id int unsigned primary key not null,
    tr_date date not null, -- time record date
    tech_id int unsigned not null,
    base_rate decimal(8,2),
    fuel_fee_rate decimal(8,2),
    pager_fee_rate decimal(8,2),    
    wait_time_rate decimal(8,2),
    drive_time_fee_rate decimal(8,2),
    admin_fee_rate decimal(8,2),
    training_rate decimal(8,2),
    holiday_fee_rate decimal(8,2),
    company_id int unsigned not null,
    test_name varchar(255) not null
);
