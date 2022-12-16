CREATE SCHEMA wichat;
SET SCHEMA 'wichat';
START TRANSACTION;
SET TIME ZONE 'Europe/Paris';

CREATE SEQUENCE messages_seq;

CREATE TABLE IF NOT EXISTS messages (
  id int NOT NULL DEFAULT NEXTVAL ('messages_seq'),
  authorId int NOT NULL,
  message text NOT NULL,
  timestamp timestamp(0) NOT NULL DEFAULT now(),
  PRIMARY KEY (id)
)  ;

ALTER SEQUENCE messages_seq RESTART WITH 3;

CREATE INDEX authorId ON messages (authorId);

INSERT INTO messages (id, authorId, message, timestamp) VALUES
(1, 1, 'Coucou tout le monde !', '2022-11-18 18:01:54'),
(2, 2, 'Salut, je suis un nouvel utilisateur', '2022-12-01 20:50:29');

CREATE SEQUENCE users_seq;

CREATE TABLE IF NOT EXISTS users (
  id int NOT NULL DEFAULT NEXTVAL ('users_seq'),
  nickname varchar(64) NOT NULL,
  PRIMARY KEY (id)
)  ;

ALTER SEQUENCE users_seq RESTART WITH 3;

INSERT INTO users (id, nickname) VALUES
(1, 'Admin'),
(2, 'TestUser');

ALTER TABLE messages
  ADD CONSTRAINT messages_author_fk FOREIGN KEY (authorId) REFERENCES users (id);
COMMIT;

-- --------------------------------------------------------
-- Utilisateurs
CREATE USER reader WITH PASSWORD 'WClr4--';
CREATE USER writer WITH PASSWORD 'WClw2--';
CREATE USER editor WITH PASSWORD 'WClrw6--';
-- Privilèges
GRANT SELECT ON ALL TABLES IN SCHEMA wichat TO reader;
GRANT INSERT ON ALL TABLES IN SCHEMA wichat TO writer;
GRANT SELECT, INSERT ON ALL TABLES IN SCHEMA wichat TO editor;
GRANT USAGE ON SCHEMA wichat TO reader;
GRANT USAGE ON SCHEMA wichat TO writer;
GRANT USAGE ON SCHEMA wichat TO editor;

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA wichat TO reader;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA wichat TO writer;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA wichat TO editor;