-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY,
	user_name varchar(20) NOT NULL,
	user_password varchar(50) NOT NULL,
	user_added TIMESTAMP,
	user_admin boolean DEFAULT FALSE
);

CREATE TABLE Category(
	id SERIAL PRIMARY KEY,
	cat_name varchar(50) NOT NULL
);

CREATE TABLE Topic(
	id SERIAL PRIMARY KEY,
	topic_topic varchar(50) NOT NULL,
	topic_content text NOT NULL,
	topic_added TIMESTAMP,
	kayttaja_id INTEGER REFERENCES Kayttaja(id),
	category_id INTEGER REFERENCES Category(id)
);

CREATE TABLE Reply(
	id SERIAL PRIMARY KEY,
	reply_content text NOT NULL,
	reply_added TIMESTAMP,
	kayttaja_id INTEGER REFERENCES Kayttaja(id),
	topic_id INTEGER REFERENCES Topic(id)
);
