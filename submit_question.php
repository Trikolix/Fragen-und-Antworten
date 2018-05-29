<?php 
include "connect.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>Fragen & Antworten | Frage erstellen</title>              
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
			echo "Sie sind eingeloggt als ".$row->username.". | <a href='submit_question.php'>Frage einreichen</a> | <a href='logout.php'>Ausloggen</a>";
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
echo '<a href="main.php">zurück</a>';
function get_anti_spam_code(){
	$anti_spam_value = 234;
	$anti_spam = (date("dmy", time())) + $anti_spam_value;
	return $anti_spam;
}

$frage = "";
$antwort1 = "";
$antwort2 = "";
$antwort3 = "";
$antwort4 = "";
$erfolg = 0;
$flag1 = 0;
$flag2 = 0;
$flag3 = 0;
$flag4 = 0;

if ($_POST)
{
	$erfolg = 1;
	
	//Frage
	$frage = $_POST['frage'];
	if ( (5 > strlen($frage)) ||(strlen($frage) > 60))
	{
		$erfolg = 0;
		$ausgabe = "Die Frage scheint mir ganz schön kurz oder viel zu lang zu sein!<br>";
	}
	
	//Antworten
	$antwort1 = $_POST['antwort1'];
	$antwort2 = $_POST['antwort2'];
	$antwort3 = $_POST['antwort3'];
	$antwort4 = $_POST['antwort4'];
	
	//Flags
	if (isset($_POST['flag1']))
		$flag1 = 1;
	if (isset($_POST['flag2']))
		$flag2 = 1;
	if (isset($_POST['flag3']))
		$flag3 = 1;
	if (isset($_POST['flag4']))
		$flag4 = 1;
	
	if (!isset($_SESSION['userid'])){
		$erfolg = 0;
		$ausgabe = "Nur eingeloggte Benutzer können neue Fragen anlegen!<br>";
	}
		
	//Eintragen in Datenbank
	if ($erfolg == 1)
	{	
		$abfrage = mysqli_query($db, "INSERT INTO questions (question, creator_id) values ('".$frage."', '".$_SESSION['userid']."')");
		$question_id = mysqli_insert_id($db);
		
		if (strlen($antwort1) > 0)
		{
			$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort1."', '".$flag1."' )");
		
		if (strlen($antwort2) > 0)
			$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort2."', '".$flag2."' )");
		
		if (strlen($antwort3) > 0)
			$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort3."', '".$flag3."' )");
		
		if (strlen($antwort4) > 0)
			$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort4."', '".$flag4."' )");
		}
		
		$Kontrolle = mysqli_query($db, "SELECT * FROM answers WHERE question_id=".$question_id."");
		if ($Kontrolle != null)
		{
			echo "<script type='text/javascript'>alert('Ihre Frage wurde erfolgreich erstellt!')</script>";
		}
		else 
		{
			echo "<script type='text/javascript'>alert('Ihre Frage konnte nicht in die Datenbank geschrieben werden!')</script>";
		}
	}
}
echo "<form method='post' action='submit_question.php' class='form'>
	<table class='anmeldung'>
		<colgroup><col width='180px'><col width='500px'></colgroup>	
			<tr><td>Frage:</td><td><input name='frage' type='text' required='true' size='60' maxlength='100'></td></tr>
			<tr><td>Antwort 1:</td><td><input name='antwort1' type='text' required='true' maxlength='60' size='35'><input name='flag1' type='checkbox' value='flag1'>richtig</td></tr>
			<tr><td>Antwort 2:</td><td><input name='antwort2' type='text' maxlength='60' size='35'><input name='flag2' type='checkbox' value='flag2'>richtig</td></tr>
			<tr><td>Antwort 3:</td><td><input name='antwort3' type='text' maxlength='60' size='35'><input name='flag3' type='checkbox' value='flag3'>richtig</td></tr>
			<tr><td>Antwort 4:</td><td><input name='antwort4' type='text' maxlength='60' size='35'><input name='flag4' type='checkbox' value='flag4'>richtig</td></tr>
		</table>
	<input type='hidden' name='sp-".get_anti_spam_code()."' value='1' />
	<input type='submit' value='Absenden' class='sendbutton'>		 
</form>";

?>
  </div>
  </center>
</body>
