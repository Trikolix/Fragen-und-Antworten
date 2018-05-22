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
if (isset($_SESSION['userid']))
	{
		$userid = $_SESSION['userid'];
		$questionAll = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid."");
		$correctAnswers = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid." AND flag = 1");
		$incorrectAnswers = mysqli_query($db, "SELECT * FROM given_answers WHERE user_id=".$userid." AND flag = 0");
	}

echo "	<br>
		Sie haben ".mysqli_num_rows($questionAll)." Fragen beantwortet.<br>
		Sie haben ".mysqli_num_rows($correctAnswers)." richtig beantwortet.<br>
		Sie haben ".mysqli_num_rows($incorrectAnswers)." falsch beantwortet.<br>";


echo '<br><a href="index.php">Fragen beantworten</a>
		<br><a href="register.php">Nutzer anlegen</a>
		<br><a href="submit_question.php">Fragen anlegen</a>';
?>
  </div>
  </center>
</body>