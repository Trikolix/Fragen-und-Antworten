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
  <div id="login">
	<?php
		if (isset($_SESSION['userid']))
		{
			$statement = mysqli_query($db, "SELECT * FROM users WHERE id=".$_SESSION['userid']."");
			$row = mysqli_fetch_object($statement);
			echo "Sie sind eingeloggt als <a href='main.php'>".$row->username."</a>. | <a href='submit_question.php'>Frage einreichen</a> | <a href='logout.php'>Ausloggen</a>";
		}
		else
		{
			echo "<a href='login.php'>Einloggen</a>";
		}	
	?>
  </div>
  <center> 
  <div id="header">
	Fragen und Antworten
  </div>
  <div id="main">
  <?php
  
  echo "<a href='main.php'>zurück</a><br>";
  //ID Der Frage wird über Link mitgegeben
  $questionID = $_GET["question"];
  $action = $_GET["action"];
  $submit = $_GET["submit"];
  
  $question = mysqli_fetch_object(mysqli_query($db, "SELECT * FROM questions WHERE id=".$questionID.""));
  if(($question->creator_id != $_SESSION['userid']) AND ($_SESSION['rights'] > 2))
  {
	  echo "Nur der Ersteller der Frage oder ein Admin, darf Fragen beenden, löschen oder bearbeiten!";
  }
  else
  {
	  switch($action){
	  case "delete": 
		  if ($submit != 1)
		  {
			echo "Wollen Sie die Frage <i>".$question->question."</i> wirklich löschen?<br>
				  <a href='edit_question?question=".$questionID."&action=".$action."&submit=1'>Ja jetzt löschen</a> !Achtung kann nicht rückgängig gemacht werden!";
		  }
		  else
		  {
			  //Hier wird Fragae inklusive aller Antwortmöglichkeiten gelöscht.
		  }	  
		break;
	  case "change": break;
	  case "end": break;
	  default: 
		echo "Da trat wohl ein Fehler auf.<a href='question.php?question=".$questionID."'>Zurück</a>";
		break;
	  }
  }
  ?>  
  </div>
  </center>
</body>