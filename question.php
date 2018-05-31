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
  
  echo "<br>";
  //ID Der Frage wird über Link mitgegeben
  $questionID = $_GET["question"];
  
  $question = mysqli_fetch_object(mysqli_query($db, "SELECT * FROM questions WHERE id=".$questionID.""));
  if(($question->creator_id != $_SESSION['userid']) AND ($_SESSION['rights'] > 2))
  {
	  echo "Nur der Ersteller der Frage oder ein Admin, darf die Statistiken zu der Frage einsehen!";
  }
  else
  {
	//Auswertung und Statistik über Frage
	
	$allAnswers = mysqli_query($db, "SELECT * FROM answers WHERE question_id=".$questionID."");
	$totalAnswers = mysqli_num_rows(mysqli_query($db, "SELECT * FROM given_answers WHERE question_id=".$questionID.""));
	
	echo "<h3>Frage</h3>
			".$question->question."<br><br>";
	echo "Erstellt am: <b>".$question->creation_time."</b> Beendet: <b>";
	if ($question->end_time == NULL)
	{
		echo "noch nicht</b><br><br>";
	}
	else
	{
		echo $question->end_time."</b><br><br>";
	}
	echo "<i>Diese Frage wurde von </i><b>".$totalAnswers." Person(en) </b><i> beantwortet.</i><br><br>";

	echo "<table>
			<tr>
				<th>Antworten</th>
				<th>richtig / falsch</th>
				<th align='center'>Wie oft getippt?</th>
				<th align='right'>%</th>
			</tr>";
	while ($singleAnswer = mysqli_fetch_object($allAnswers))
	{
		$timesAnswered = mysqli_num_rows(mysqli_query($db, "SELECT * FROM given_answers WHERE answer_id=".$singleAnswer->id.""));
		echo "<tr>
				<td>".$singleAnswer->answer."</td>
				<td align='center'>".$singleAnswer->flag."</td>
				<td align='center'>".$timesAnswered."</td>";
		if ($timesAnswered > 0)
		{
			echo "<td align='right'>".($timesAnswered/$totalAnswers*100)."%</td>
			</tr>";
		}
		else
		{
			echo "<td align='right'>0%</td>
			</tr>";
		}
	}
	echo "</table>";
	
	//TODO: folgende Funktionen einbauen
	echo "<h3>Aktionen</h3>
	<a href='edit_question.php?question=".$questionID."&action=delete'>Löschen</a><br>";
	if ($question->end_time == NULL)
	{
		echo "<a href='edit_question.php?question=".$questionID."&action=end'>Beenden</a><br>";
	}
  }
  ?>
  </div>
  </center>
</body>