CREATE DATABASE travel_agency;

CREATE TABLE `users` (
  `recid` bigint(20) NOT NULL AUTO_INCREMENT,  `firstname` varchar(25) DEFAULT NULL,  `lastname` varchar(25) DEFAULT NULL,  `email` varchar(150) DEFAULT NULL,  `phoneno` varchar(25) DEFAULT NULL,  `password` varchar(150) DEFAULT NULL,  `filename` varchar(255) DEFAULT NULL,`flapproved` char(1) NOT NULL DEFAULT 'N',  `earnedrewards` decimal(20,4) NOT NULL DEFAULT 0.0000,  `datetimex` date DEFAULT NULL,  `endeffdt` date DEFAULT NULL, PRIMARY KEY (`recid`));

CREATE TABLE `question` (`recid` BIGINT(20) NOT NULL AUTO_INCREMENT , `added` BIGINT(20) NOT NULL DEFAULT '0' , `question` TEXT NULL DEFAULT NULL , `description` TEXT NULL DEFAULT NULL , `reward` INT(20) NOT NULL DEFAULT '0' , `datetimex` DATETIME NULL DEFAULT NULL , `endeffdt` DATE NULL DEFAULT NULL , PRIMARY KEY (`recid`));

CREATE TABLE `answers` (`recid` BIGINT(20) NOT NULL AUTO_INCREMENT , `questionid` BIGINT(20) NOT NULL DEFAULT '0' , `answeredby` BIGINT(20) NOT NULL DEFAULT '0' , `answer` TEXT NULL DEFAULT NULL , `flapproved` CHAR(1) NOT NULL DEFAULT 'N' , `datetimex` DATETIME NULL DEFAULT NULL , `endeffdt` DATE NULL DEFAULT NULL , PRIMARY KEY (`recid`));