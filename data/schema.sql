CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT, username varchar(100) NOT NULL, hashedPassword varchar(100) NOT NULL);
INSERT INTO user (username, hashedPassword) VALUES ('awest', '$2y$10$ADa2lOqvFkNq2kkTvBqC4eq8CInJGc6LC1/9hq3W/FYOs2.Bgyiua');

CREATE TABLE cat (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(100) NOT NULL, race varchar(100) NOT NULL);
INSERT INTO cat (name, race) VALUES ('Fluffy', 'Gray');
INSERT INTO cat (name, race) VALUES ('Adele', 'Persian');
INSERT INTO cat (name, race) VALUES ('Mittens', 'White');
INSERT INTO cat (name, race) VALUES ('Paul', 'Not human');
INSERT INTO cat (name, race) VALUES ('Kitty', 'Bad');

