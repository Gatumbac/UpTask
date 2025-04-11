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

CREATE TABLE PROJECTS (
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    url VARCHAR(32),
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE RESTRICT
);

CREATE TABLE TASKS (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(60) NOT NULL,
	status TINYINT NOT NULL DEFAULT 0,
	project_id INT NOT NULL,
	FOREIGN KEY (project_id) REFERENCES PROJECTS(id) ON DELETE CASCADE	 
);