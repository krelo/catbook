PRAGMA foreign_keys = ON;

CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT, username varchar(100) NOT NULL, hashedPassword varchar(100) NOT NULL);
INSERT INTO user (username, hashedPassword) VALUES ('awest', '$2y$10$ADa2lOqvFkNq2kkTvBqC4eq8CInJGc6LC1/9hq3W/FYOs2.Bgyiua');
INSERT INTO user (username, hashedPassword) VALUES ('hellokitty', '$2y$10$mDNQqE/PWAwkYzybTrZNu.A74.95zqt9zmsgXGSBjKoqAon/FFoYq');

CREATE TABLE cat (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(100) NOT NULL, race varchar(100) NOT NULL, owner_id INTEGER NOT NULL, FOREIGN KEY (owner_id) REFERENCES user (id));
INSERT INTO cat (name, race, owner_id) VALUES ('Fluffy', 'Gray', 1);
INSERT INTO cat (name, race, owner_id) VALUES ('Adele', 'Persian', 1);
INSERT INTO cat (name, race, owner_id) VALUES ('Mittens', 'White', 1);
INSERT INTO cat (name, race, owner_id) VALUES ('Paul', 'Not human', 2);
INSERT INTO cat (name, race, owner_id) VALUES ('Kitty', 'Bad', 2);

