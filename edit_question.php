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
			echo "<a href='login.php'>Einloggen</a> | <a href='register.php'>Registrieren</a>";
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
  if (isset($_GET["submit"]))
  {
	  $submit = $_GET["submit"];
  }
  else
  {
	  $submit = 0;
  }
  
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
			echo "Wollen Sie die Frage \"<i>".$question->question."</i>\" wirklich löschen?<br>
				  <a href='edit_question.php?question=".$questionID."&action=".$action."&submit=1'>Ja jetzt löschen</a> !Achtung kann nicht rückgängig gemacht werden!";
		  }
		  else
		  {
			  //Hier wird Fragae inklusive aller Antwortmöglichkeiten gelöscht.
			  $delete = mysqli_query($db, "DELETE FROM given_answers WHERE question_id=".$questionID."");
			  $delete = mysqli_query($db, "DELETE FROM answers WHERE question_id=".$questionID."");
			  $delete = mysqli_query($db, "DELETE FROM questions WHERE id=".$questionID."");
			  echo "Die Frage wurde erfolgreich gelöscht.";
		  }	  
		break;
	  case "change": break;
	  case "end": 
		if ($submit != 1)
		  {
			echo "Wollen Sie die Frage \"<i>".$question->question."</i>\" wirklich beenden?<br>
					Leute können dann nicht mehr auf die Frage antworten, Sie können allerdings immer noch die Statistiken dazu einsehen.<br>
					<a href='edit_question.php?question=".$questionID."&action=".$action."&submit=1'>Ja jetzt beenden</a>";
		  }
		  else
		  {
			  //Hier wird Fragae inklusive aller Antwortmöglichkeiten gelöscht.
			  $end = mysqli_query($db, "UPDATE questions SET end_time=CURRENT_TIMESTAMP WHERE id=".$questionID."");
			  echo "Die Frage wurde erfolgreich gelöscht.";
		  }	 
	  break;
	  default: 
		echo "Da trat wohl ein Fehler auf.<a href='question.php?question=".$questionID."'>Zurück</a>";
		break;
	  }
  }
  ?>  
  </div>
  </center>
</body>
