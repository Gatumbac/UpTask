CREATE DATABASE UPTASK;
USE UPTASK;

CREATE TABLE USERS (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
	confirmed TINYINT DEFAULT 0,
	token VARCHAR(15)
); 

INSERT INTO USERS(name, lastname, email, password) VALUES ('Gabriel', 'Tumbaco', 'gabrieltumbaco2005@outlook.es', 'gaboalej2005');