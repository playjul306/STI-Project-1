----
-- phpLiteAdmin database dump (https://bitbucket.org/phpliteadmin/public)
-- phpLiteAdmin version: 1.9.6
-- Exported: 8:47am on September 27, 2019 (UTC)
-- database file: /usr/share/nginx/databases/database.sqlite
--
-- Autheurs: Benoit Julien, Sutcu Volkan
----
BEGIN TRANSACTION;
PRAGMA foreign_keys = ON;
----
-- Table structure for Message
----
CREATE TABLE 'Message' ('id_message' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'sujet' TEXT, 'corps' TEXT, 'date' TEXT, 'expediteur' INTEGER NOT NULL, 'recepteur' INTEGER NOT NULL,
FOREIGN KEY (recepteur) REFERENCES Utilisateur(id_login),
FOREIGN KEY (expediteur) REFERENCES Utilisateur(id_login));


----
-- Table structure for Utilisateur
----
CREATE TABLE 'Utilisateur' ('id_login' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'login' TEXT NOT NULL, 'password' TEXT NOT NULL, 'valide' BOOLEAN NOT NULL, 'id_role' INTEGER NOT NULL, 
FOREIGN KEY (id_role) REFERENCES Role(id_role));


----
-- Table structure for Role
----
CREATE TABLE 'Role' ('id_role' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'nom_role' TEXT NOT NULL);

INSERT INTO "Role" ("id_role","nom_role") VALUES ('1','administrateur');
INSERT INTO "Role" ("id_role","nom_role") VALUES ('2','collaborateur');


INSERT INTO "Utilisateur" ("id_login","login","password","valide","id_role") VALUES ('1','volkan','$2y$10$huu4QydHJisVw0NMrSlNzusXZfhDHSu69D2Hpe0qBEtq2MqXYP.Nu','1','1');
INSERT INTO "Utilisateur" ("id_login","login","password","valide","id_role") VALUES ('2','julien','$2y$10$H9u.7Y2EF9AXwfm4jJrAQeQtLUiE2V1OQkv1X/Opc.xA8F3IBsSQa','1','2');

INSERT INTO "Message" ("id_message","sujet","corps","date","expediteur","recepteur") VALUES ('1','test1','texte de test1','21-08-2019 06:52:54','1','2');
INSERT INTO "Message" ("id_message","sujet","corps","date","expediteur","recepteur") VALUES ('2','test2','texte de test2','26-05-2018 13:02:14','2','1');

COMMIT;
