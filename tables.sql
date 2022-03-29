CREATE TABLE appUser (
username VARCHAR(32) NOT NULL PRIMARY KEY,
password VARCHAR(255) NOT NULL
);

CREATE TABLE follows (
id SERIAL PRIMARY KEY,
followee VARCHAR(32) NOT NULL,
follower VARCHAR(32) NOT NULL,
FOREIGN KEY(follower) REFERENCES appUser(username),
FOREIGN KEY(followee) REFERENCES appUser(username)
);

CREATE TABLE fight (
id SERIAL PRIMARY KEY
);

CREATE TABLE contestant (
id SERIAL PRIMARY KEY,
username VARCHAR(64) NOT NULL
);

CREATE TABLE fightContestant (
id SERIAL PRIMARY KEY,
fightId INT NOT NULL,
contestantId INT NOT NULL,
FOREIGN KEY(fightId) REFERENCES fight(id),
FOREIGN KEY(contestantId) REFERENCES contestant(id)
);

CREATE TABLE vote (
id SERIAL PRIMARY KEY,
voter VARCHAR(32) NOT NULL,
fightContestantId INT NOT NULL,
FOREIGN KEY(voter) REFERENCES appUser(username),
FOREIGN KEY(fightContestantId) REFERENCES fightContestant(id)
);

CREATE TABLE comment (
id SERIAL PRIMARY KEY,
content TEXT NOT NULL,
author VARCHAR(32),
fightId INT NOT NULL,
FOREIGN KEY(author) REFERENCES appUser(username),
FOREIGN KEY(fightId) REFERENCES fight(id)
);

INSERT INTO appUser(username, password) VALUES ('test', 'test');
INSERT INTO fight(bracketId) VALUES (1);


drop table comment;
drop table vote;
drop table fightcontestant;
drop table contestant;
drop table fight;
drop table bracket;
drop table follows;
drop table appUser