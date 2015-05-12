-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: mobile_drug_testing
-- Source Schemata: mobile_drug_testing
-- Created: Mon May 11 19:40:29 2015
-- Workbench Version: 6.3.3
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema mobile_drug_testing
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `mobile_drug_testing` ;
CREATE SCHEMA IF NOT EXISTS `mobile_drug_testing` ;

-- ----------------------------------------------------------------------------
-- Table mobile_drug_testing.companies
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile_drug_testing`.`companies` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(255) NOT NULL,
  `addr1` VARCHAR(100) NOT NULL,
  `addr2` VARCHAR(100) NULL DEFAULT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(2) NOT NULL,
  `zip` INT(5) NOT NULL,
  `company_phone` VARCHAR(12) NOT NULL,
  `company_der` VARCHAR(100) NOT NULL,
  `additional_phone` VARCHAR(12) NULL DEFAULT NULL,
  `email` VARCHAR(150) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table mobile_drug_testing.employees
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile_drug_testing`.`employees` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first` VARCHAR(50) NOT NULL,
  `last` VARCHAR(50) NOT NULL,
  `addr1` VARCHAR(100) NOT NULL,
  `addr2` VARCHAR(100) NULL DEFAULT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(2) NOT NULL,
  `zip` INT(5) NOT NULL,
  `phone` VARCHAR(12) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `ssn` VARCHAR(11) NOT NULL,
  `dob` DATE NOT NULL,
  `active` TINYINT(1) NULL DEFAULT '1',
  `bat_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table mobile_drug_testing.login
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile_drug_testing`.`login` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(50) NOT NULL,
  `pwd` VARCHAR(60) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`))
ENGINE = MyISAM
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table mobile_drug_testing.test_types
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile_drug_testing`.`test_types` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table mobile_drug_testing.tests
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile_drug_testing`.`tests` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `test_name` VARCHAR(255) NOT NULL,
  `company` VARCHAR(255) NOT NULL,
  `number_of_tests` INT(4) NOT NULL,
  `tech_id` INT(11) NOT NULL,
  `test_date` DATE NOT NULL,
  `comments` BLOB NULL DEFAULT NULL,
  `rate_type` VARCHAR(10) NOT NULL,
  `num_hours` INT(11) NULL DEFAULT NULL,
  `base_fee` DECIMAL(8,2) NOT NULL,
  `additional_test_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `fuel_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `pager_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `wait_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `drive_time_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `admin_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `training_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `holiday_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `misc_fee` DECIMAL(8,2) NULL DEFAULT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = latin1;
SET FOREIGN_KEY_CHECKS = 1;
