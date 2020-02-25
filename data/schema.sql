PRAGMA foreign_keys = ON;

CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT, username varchar(100) NOT NULL, hashedPassword varchar(100) NOT NULL, name varchar(100) NOT NULL);
INSERT INTO user (username, hashedPassword, name) VALUES ('awest', '$2y$10$ADa2lOqvFkNq2kkTvBqC4eq8CInJGc6LC1/9hq3W/FYOs2.Bgyiua', 'Mayor West');
INSERT INTO user (username, hashedPassword, name) VALUES ('hellokitty', '$2y$10$mDNQqE/PWAwkYzybTrZNu.A74.95zqt9zmsgXGSBjKoqAon/FFoYq', 'Kitty Ohaiyo');

CREATE TABLE cat (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(100) NOT NULL, race varchar(100) NOT NULL, owner_id INTEGER NOT NULL, photo_url varchar(100), FOREIGN KEY (owner_id) REFERENCES user (id));
INSERT INTO cat (name, race, photo_url, owner_id) VALUES ('Fluffy', 'Gray', 'https://cataas.com/cat?701', 1);
INSERT INTO cat (name, race, photo_url, owner_id) VALUES ('Adele', 'Persian', 'https://cataas.com/cat?702', 2);
INSERT INTO cat (name, race, photo_url, owner_id) VALUES ('Mittens', 'White', NULL, 1);
INSERT INTO cat (name, race, photo_url, owner_id) VALUES ('Paul', 'Not human', 'https://cataas.com/cat?704',1);
INSERT INTO cat (name, race, photo_url, owner_id) VALUES ('Kitty', 'Bad', 'https://cataas.com/cat?705', 2);

