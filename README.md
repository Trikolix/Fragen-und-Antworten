# Fragen-und-Antworten

Datenbank: SQLite
Entwicklungsumgebung: jeder für sich
Tabellen:
- Logindaten (ID, NUtzername, Passwort, NAme, Nutzergruppe(ID))
- Nutzergruppen (ID, BEzeichnung)
	Admins --> Fragen erstellen, beantworten, Statistik zu eigenen Fragen (eigene Fragen bearbeiten / löschen)
	Studenten / Nutzer --> Fragen beantworten
	evtl. Superadmin --> kann alles
- Fragen (ID, Frage, ErstellerId)
- Antworten (ID, Antwort, Flag(Richtig/falsch), FRageID)
- gegebene Antworten(iD, FRageId, NutzerId, AntwortId, Datum, Flag(richtig/falsch))

Seiten
header.php
-Session mitgeben
-Benutzercontrollfeld (wer ist eingelogt, ausloggen, (frage bearbeiten))
index.php
-login

login2.php
-überprüft eingegebene Logindaten, leitet weiter

fragen.php
-zeigt fragen an, wertet Antwort aus

auswertung.php


fragen-erstellen.php
-

logout.php
-
