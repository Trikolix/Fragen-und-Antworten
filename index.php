<?php 
include "connect.php";
if (isset($_GET['answered']))
{
	$answer = $_POST['Frage'];
	if (isset($_SESSION['userid']))
	{
		$statement = mysqli_query($db, "SELECT * FROM answers WHERE id=".$answer."");
		$row = mysqli_fetch_object($statement);
		$question = $row->question_id;
		$flag = $row->flag;
		
		$count = mysqli_num_rows(mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$_SESSION['userid']." AND question_id=".$question.""));
		if ($count > 0)
		{
			//Eintrag in Datenbank bereits vorhanden - ggf. Antwort korrigieren, bis jetzt nur Ausgabe Fehlermeldung
			$error = "Eintrag in Datenbank nicht möglich. Es ist bereits ein Eintrag für die Frage von dem User vorhanden.";
		}
		else
		{
			//Antwort wird in Datenbank geschrieben
			$statement = mysqli_query($db, "INSERT INTO given_answers (user_id, question_id, answer_id, flag) VALUES (".$_SESSION['userid'].", ".$question.", ".$answer.", ".$flag.")");
			if ($flag == 1)
			{
				echo "<script type='text/javascript'>alert('Deine Antwort ist richtig!')</script>";
			}
			else 
			{
				echo "<script type='text/javascript'>alert('Deine Antwort ist falsch!')</script>";
			}
		}
		
	}
	else
	{
		$error = "Melden Sie sich bitte erst an um eine Frage beantworten zu können. <a href='login.php'>Hier gehts zum Login.</a><br>";
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>Fragen & Antworten</title>              
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
	
	if (isset($error))
		echo "<center><div id='error'>".$error."</div></center>";
		
	$statement = mysqli_query($db, "SELECT * FROM questions ORDER BY RAND() LIMIT 1");
	while ($row = mysqli_fetch_object($statement))
	{
		$id = $row->id;
		echo "<form action='?answered=1' method='post'>
				<p>".$row->question."</p>
				<fieldset>";
	}
	$statement = mysqli_query($db, "SELECT * FROM answers WHERE question_id=".$id." ORDER BY RAND()");
	while ($row = mysqli_fetch_object($statement))
	{
		echo "<input type='radio' id='answer_a' name='Frage' value='".$row->id."'><label for='answer_a'>".$row->answer."</label>";
	}
	echo "
			
			</fieldset>
		<center><button>Absenden</button></center>
	</form>";
?>
  </div>
  </center>
</body>