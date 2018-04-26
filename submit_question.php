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
}
echo "<form method='post' action='anmeldung.php' class='form'>
	<table class='anmeldung'>
		<colgroup><col width='180px'><col width='500px'></colgroup>	
			<tr><td>Frage:</td><td><input name='name' type='text' required='true' size='60' maxlength='100' value='".$frage."'></td></tr>
			<tr><td>Antwort 1:</td><td><input name='vorname' type='text' required='true' maxlength='60' size='35' value='".$antwort1."'><input name='flag1' type='checkbox' value='flag1'>richtig</td></tr>
			<tr><td>Antwort 2:</td><td><input name='vorname' type='text' required='true' maxlength='60' size='35' value='".$antwort2."'><input name='flag2' type='checkbox' value='flag2'>richtig</td></tr>
			<tr><td>Antwort 3:</td><td><input name='vorname' type='text' required='true' maxlength='60' size='35' value='".$antwort3."'><input name='flag3' type='checkbox' value='flag3'>richtig</td></tr>
			<tr><td>Antwort 4:</td><td><input name='vorname' type='text' required='true' maxlength='60' size='35' value='".$antwort4."'><input name='flag4' type='checkbox' value='flag4'>richtig</td></tr>
		</table>
	<input type='hidden' name='sp-".get_anti_spam_code()."' value='1' />
	<input name='haftung' type='checkbox' value='haftung' required='true' style='margin-left: 130px;'> Ich habe die <a href=\"haftungsfreistellung.html\" target=\"fenster\" onclick=\"window.open('haftungsfreistellung.html','fenster', 'width=600,height=450,status,resizable,scrollbars')\">Haftungsfreistellung</a> gelesen und akzeptiere diese.<br>
	<input type='submit' value='Absenden' class='sendbutton'>		 
</form>"


?>