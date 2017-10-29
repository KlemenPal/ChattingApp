CREATE TABLE uporabnik
(
	id INT unsigned NOT NULL,
	username VARCHAR(25) NOT NULL,
	password VARCHAR(25) NOT NULL,
	PRIMARY KEY (id)
	);
	
	create table uporabnik(
 id INT unsigned NOT NULL AUTO_INCREMENT,
 username varchar(25),
 password varchar(25),
 primary key(id)
 );
 insert into uporabnik (id, username, password) values
 (1, 'prviuser', 'passworduser');