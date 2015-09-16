-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (user_name, user_password, user_added, user_admin) VALUES
('temekkelisti', 'mitalli', NOW(), false);
INSERT INTO Kayttaja (user_name, user_password, user_added, user_admin) VALUES
('tmekk', 'mitalli1', NOW(), true);

INSERT INTO Category (cat_name) VALUES ('testikategoria');

INSERT INTO Topic (topic_topic, topic_content, topic_added) VALUES
('eka topikki', 'tää on kontentti', NOW());

INSERT INTO Reply (reply_content, reply_added, topic_id) VALUES
('eka vastaus', NOW(), 1);

INSERT INTO Reply (reply_content, reply_added, topic_id) VALUES
('toka vastaus', NOW(), 1);