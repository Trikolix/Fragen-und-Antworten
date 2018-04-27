<?php
include "connect.php";

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
	$antwort1 = $_POST['antwort1'];
	$antwort2 = $_POST['antwort2'];
	$antwort3 = $_POST['antwort3'];
	$antwort4 = $_POST['antwort4'];
	
	if (isset($_POST['flag1']))
		$flag1 = 1;
	echo $flag1;
	if (isset($_POST['flag2']))
		$flag2 = 1;
	echo $flag2;
	if (isset($_POST['flag3']))
		$flag3 = 1;
	echo $flag3;
	if (isset($_POST['flag4']))
		$flag4 = 1;
	echo $flag4;
	
	$abfrage = mysqli_query($db, "INSERT INTO questions (question) values ('".$frage."')");
	$question_id = mysqli_insert_id($db);
	
	if (strlen($antwort1) > 0){
		echo "yes";
		$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort1."', '".$flag1."' )");
		var_dump($abfrage);
	}
	
	if (strlen($antwort2) > 0)
		$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort2."', '".$flag2."' )");
	
	if (strlen($antwort3) > 0)
		$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort3."', '".$flag3."' )");
	
	if (strlen($antwort4) > 0)
		$abfrage = mysqli_query($db, "INSERT INTO answers (question_id, answer, flag) values ('".$question_id."', '".$antwort4."', '".$flag4."' )");
}
echo "<form method='post' action='submit_question.php' class='form'>
	<table class='anmeldung'>
		<colgroup><col width='180px'><col width='500px'></colgroup>	
			<tr><td>Frage:</td><td><input name='frage' type='text' required='true' size='60' maxlength='100' value='".$frage."'></td></tr>
			<tr><td>Antwort 1:</td><td><input name='antwort1' type='text' required='true' maxlength='60' size='35' value='".$antwort1."'><input name='flag1' type='checkbox' value='flag1'>richtig</td></tr>
			<tr><td>Antwort 2:</td><td><input name='antwort2' type='text' maxlength='60' size='35' value='".$antwort2."'><input name='flag2' type='checkbox' value='flag2'>richtig</td></tr>
			<tr><td>Antwort 3:</td><td><input name='antwort3' type='text' maxlength='60' size='35' value='".$antwort3."'><input name='flag3' type='checkbox' value='flag3'>richtig</td></tr>
			<tr><td>Antwort 4:</td><td><input name='antwort4' type='text' maxlength='60' size='35' value='".$antwort4."'><input name='flag4' type='checkbox' value='flag4'>richtig</td></tr>
		</table>
	<input type='hidden' name='sp-".get_anti_spam_code()."' value='1' />
	<input name='haftung' type='checkbox' value='haftung' required='true' style='margin-left: 130px;'> Ich habe die <a href=\"haftungsfreistellung.html\" target=\"fenster\" onclick=\"window.open('haftungsfreistellung.html','fenster', 'width=600,height=450,status,resizable,scrollbars')\">Haftungsfreistellung</a> gelesen und akzeptiere diese.<br>
	<input type='submit' value='Absenden' class='sendbutton'>		 
</form>"


?>