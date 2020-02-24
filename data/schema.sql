CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT, username varchar(100) NOT NULL, password varchar(100) NOT NULL);
INSERT INTO user (username, password) VALUES ('awest', '1234');

CREATE TABLE cat (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(100) NOT NULL, race varchar(100) NOT NULL);
INSERT INTO cat (name, race) VALUES ('Fluffy', 'Gray');
INSERT INTO cat (name, race) VALUES ('Adele', 'Persian');
INSERT INTO cat (name, race) VALUES ('Mittens', 'White');
INSERT INTO cat (name, race) VALUES ('Paul', 'Not human');
INSERT INTO cat (name, race) VALUES ('Kitty', 'Bad');

