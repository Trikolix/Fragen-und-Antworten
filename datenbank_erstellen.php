<?php
$db = new SQLite3('database.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);



$db->query('CREATE TABLE IF NOT EXISTS "user_group" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"bezeichnung" VARCHAR,
)');

$db->query('CREATE TABLE IF NOT EXISTS "users" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"username" VARCHAR,
	"password" VARCHAR,
	"real_name" VARCHAR,
    "user_group_id" INTEGER,
    "registrationdate" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_group_id) REFERENCES user_group(id)
)');

$db->query('INSERT INTO "user_group" ("id","bezeichnung")
    VALUES (1, "Superadmin")');
$db->query('INSERT INTO "user_group" ("id","bezeichnung")
    VALUES (2, "Admin")');
$db->query('INSERT INTO "user_group" ("id","bezeichnung")
    VALUES (3, "Studenten")');
	
$db->query('INSERT INTO "users" ("username", "password", "real_name", "user_group_id")
    VALUES ("superadmin", md5("Passwort"), "Horst", 1)');

$db->query('INSERT INTO "users" ("username", "password", "real_name", "user_group_id")
    VALUES ("Admin1", md5("123456"), "Christian", 2)');
$db->query('INSERT INTO "users" ("username", "password", "real_name", "user_group_id")
    VALUES ("Admin2", md5("gott"), "Martin", 2)');
$db->query('INSERT INTO "users" ("username", "password", "real_name", "user_group_id")
    VALUES ("Admin3", md5("inkorrekt"), "René", 2)');	
	
$db->query('INSERT INTO "users" ("username", "password", "real_name", "user_group_id")
    VALUES ("Penzel", md5("Salatgurke"), "Penzel", 3)');	
	
$db->query('CREATE TABLE IF NOT EXISTS "questions" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"question" VARCHAR,
	"creator_id" INTEGER,
	FOREIGN KEY (creator_id) REFERENCES users(id)
)');

$db->query('CREATE TABLE IF NOT EXISTS "answers" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"question_id" INTEGER,
	"answer" VARCHAR,
	"flag" BOOLEAN,	
	FOREIGN KEY (question_id) REFERENCES questions(id)
)');

$db->query('INSERT INTO "questions" ("id", "question", "creator_id")
    VALUES (1, "Bekommen wir eine 1,0 auf den Beleg?", 1)');	
	
$db->query('INSERT INTO "answers" ("question_id", "answer", "flag")
    VALUES (1, "Ja", 1)');
$db->query('INSERT INTO "answers" ("question_id", "answer", "flag")
    VALUES (1, "Definitiv!", 1)');	
$db->query('INSERT INTO "answers" ("question_id", "answer", "flag")
    VALUES (1, "Vielleicht", 0)');
$db->query('INSERT INTO "answers" ("question_id", "answer", "flag")
    VALUES (1, "Aber sicher doch!", 1)');
	
$db->query('CREATE TABLE IF NOT EXISTS "given_answers" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"question_id" INTEGER,
	"user_id" INTEGER,
	"answer_id" INTEGER,
	"time" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	"flag" BOOLEAN,	
	FOREIGN KEY (question_id) REFERENCES questions(id),
	FOREIGN KEY (answer_id) REFERENCES answers(id)
)');

?>