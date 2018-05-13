<?php 

include "connect.php";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>Fragen & Antworten | Registrieren</title>              
	<link href="style.css" type="text/css" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Fragen und Antworten, Der Dozent stellt Fragen, die Studenten antworten." />
	<meta name="keywords" content="Fragen, Antworten, Quiz, Auswertung, BA-Glauchau" />
	<meta name="language" content="de, at" />
  </head>  
  <body>
  <center> 
  <div id="header">
	Fragen und Antworten
  </div>
  <div id="main">
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $username = $_POST['username'];
	$realname = $_POST['realname'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
  
    if (strlen($username) < 3) {
		echo 'Der Nutzername muss mindestens 3 Buchstaben lang sein<br>';
		$error = true;
	}
	
	if (strlen($realname) < 3) {
		echo 'Bitte geben Sie ihren echten vollen Namen an<br>';
		$error = true;
	}
	
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = mysqli_query($db, "SELECT TOP 1 users.username FROM users WHERE users.username=".$username."");
		var_dump($db);
		var_dump($statement);
        $result = mysqli_num_rows($statement);
        
        if($result !== 0) {
            echo 'Dieser Username ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        
        $statement = mysqli_query($db, "INSERT INTO users (username, real_name, password, user_group_id) VALUES (".$username.", ".$realname.", ".$password_hash.", 3)");
        
        if($statement) {        
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">
Nutzername:<br>
<input type="username" size="40" maxlength="250" name="username"><br>
 
Ihr echter Name:<br>
<input type="realname" size="40" maxlength="250" name="realname"><br><br>

Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
Passwort wiederholen:<br>
<input type="password" size="40" maxlength="250" name="passwort2"><br><br>
 
<input type="submit" value="Abschicken">
</form>
 
<?php
} //Ende von if($showFormular)
?>
   </div>
</body>
</html>