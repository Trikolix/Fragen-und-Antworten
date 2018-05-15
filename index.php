<?php 
include "connect.php";
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
		
	$statement = mysqli_query($db, "SELECT * FROM questions ORDER BY RAND() LIMIT 1");
	while ($row = mysqli_fetch_object($statement))
	{
		$id = $row->id;
		echo "<form>
				<p>".$row->question."</p>
				<fieldset>";
	}
	$statement = mysqli_query($db, "SELECT * FROM answers WHERE question_id=".$id." ORDER BY RAND()");
	while ($row = mysqli_fetch_object($statement))
	{
		echo "<input type='radio' id='answer_a' name='Frage' value='".$row->id."'><label for='answer_a'>".$row->answer."</label>";
	}
	echo "</fieldset>
		<center><button>Absenden</button></center>
	</form>";
?>
  </div>
  </center>
</body>