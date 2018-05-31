<?php 
session_start();

//Server, user, passwort, datenbank für sql Verbindung hier eintragen und connect.php überall einbinden
$db = mysqli_connect("127.0.0.1", "project_user", "", "martin");

if(!$db)

{

  exit("Verbindungsfehler: ".mysqli_connect_error());

}

?>