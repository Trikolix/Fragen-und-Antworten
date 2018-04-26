<?php 
//$db = new SQLite3('database.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

//Server, user, passwort, datenbank für sql Verbindung hier eintragen und connect.php überall einbinden
$db = mysqli_connect("127.0.0.1", "project_user", "", "project_x");

if(!$db)

{

  exit("Verbindungsfehler: ".mysqli_connect_error());

}

?>