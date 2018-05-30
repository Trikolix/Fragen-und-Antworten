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
if (isset($_SESSION['userid']))
	{
		$userid = $_SESSION['userid'];
		$questionAll = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid."");
		$correctAnswers = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid." AND flag = 1");
		$incorrectAnswers = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid." AND flag = 0");
		$ownQuestions = mysqli_Query($db, "SELECT * FROM questions WHERE creator_id=".$userid."");
	

	echo "	<h3>Deine Statistik</h3>
			Sie haben ".mysqli_num_rows($questionAll)." Fragen beantwortet.<br>
			Sie haben ".mysqli_num_rows($correctAnswers)." richtig beantwortet.<br>
			Sie haben ".mysqli_num_rows($incorrectAnswers)." falsch beantwortet.<br>
			<h3>Deine Fragen</h3>";
			
	while ($question = mysqli_fetch_object($ownQuestions))
	{
		echo "<a href='question.php?question=".$question->id."'>".$question->question."</a><br>";
	}
		
}

echo "	<h3>Aktionen</h3>
		<a href='index.php'>Fragen beantworten</a><br>
		<a href='register.php'>Nutzer anlegen</a><br>
		<a href='submit_question.php'>Fragen anlegen</a>";
?>
  </div>
  </center>
</body>
