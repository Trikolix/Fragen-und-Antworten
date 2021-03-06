<?php 

include "connect.php";

if(isset($_GET['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $statement = mysqli_query($db, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_object($statement);
        
    //Überprüfung des Passworts
    if ($statement !== false && password_verify($password, $row->password)) {
        $_SESSION['userid'] = $row->id;
		$_SESSION['rights'] = $row->user_group_id;
        die(header('Location: main.php'));
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
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
  <div id="login">
	<?php
		if (isset($_SESSION['userid']))
		{
			$statement = mysqli_query($db, "SELECT * FROM users WHERE id=".$_SESSION['userid']."");
			$row = mysqli_fetch_object($statement);
			echo "Sie sind eingeloggt als <a class='Menuelink' href='main.php'>".$row->username."</a> | <a class='Menuelink' href='logout.php'>Ausloggen</a>";
		}
		else
		{
			echo "<a class='Menuelink' href='login.php'>Einloggen</a> | <a class='Menuelink' href='register.php'>Registrieren</a>";
		}	
	?>
  </div>
  <center> 
  <div id="header">
	<a class='Headerlink' href="main.php">
		Fragen und Antworten
	</a>
  </div>
  <div id="main">
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
 
<form action="?login=1" method="post">
E-Mail:<br>
<input type="username" size="40" maxlength="250" name="username"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="password"><br>
 
<input type="submit" value="Abschicken">
 
<?php


?>
  </div>
  </center>
</body>