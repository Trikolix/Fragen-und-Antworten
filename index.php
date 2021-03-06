<?php 
include "connect.php";
if (isset($_GET['answered']))
{
	if (isset($_SESSION['userid']))
	{
		if (isset($_POST['Frage'])){
			$answer = $_POST['Frage'];
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
					$success = "Deine Antwort war richtig!";
				}
				else 
				{
					$error = "Deine Antwort war leider falsch!<br>";
				}
			}
		}
	} else {
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
	<a class='Headerlink' href='main.php'>
		Fragen und Antworten
	</a>
  </div>
  <div id="main">
  <?php
	echo "<a class='Menuelink' href='main.php'>Zurück</a>";
	if (isset($error)){
		echo "<center><div id='error'>".$error."</div></center>";
	}
	if (isset($success)){
		echo "<center><div id='success'>".$success."</div></center>";
	}
	
	$id = '';	
	if (isset($_SESSION['userid']))
	{			
		$get_question = mysqli_query($db, "SELECT * 
											FROM `questions` 
											WHERE id NOT IN (
												SELECT question_id
												FROM `given_answers` 
												WHERE user_id = ".$_SESSION['userid'].") 
												AND end_time IS NULL
												ORDER BY RAND() LIMIT 1");
		if ($get_question){
			$question_count = mysqli_num_rows($get_question);
			if($question_count > 0){
				while ($row = mysqli_fetch_object($get_question))
				{
					$id = $row->id;
					echo "<form action='?answered=1' method='post'>
							<p>".$row->question."</p>
							<fieldset>";
				}
				if ($id != ''){
					$get_answers = mysqli_query($db, "SELECT * FROM answers WHERE question_id=".$id." ORDER BY RAND()");
					$answer_count = mysqli_num_rows($get_answers);
					if ($answer_count > 0){
						while ($row = mysqli_fetch_object($get_answers))
						{
							echo "<input type='radio' id='answer_".$row->id."' name='Frage' value='".$row->id."'><label for='answer_".$row->id."'>".$row->answer."</label>";
						}
						echo "
								</fieldset>
								<center><button>Absenden</button></center>
								</form>";
					} else {
						echo "Es konnten keine Antworten zu dieser Frage gefunden werden.";
					}
				} else {
					echo "<br>Es konnten keine Frage gefunden werden.";
				}
			} else {
				echo "<br>Es wurden bereits alle Fragen beantwortet.<br><center><a class='Menuelink' href='main.php'>Zurück</a></center>";
			}
		} else {
			echo "<br>Es wurden bereits alle Fragen beantwortet.<br><center><a class='Menuelink' href='main.php'>Zurück</a></center>";
		}
	} else {
		echo "<center><br>Loggen Sie sich bitte erst ein um fragen beantworten zu können.<br>
		<a class='Menuelink' href='login.php'>Login</a></center>";
	}
?>
  </div>
  </center>
</body>
