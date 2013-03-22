<?
if(!isset ($config)){ exit(127);}
function html_header($login=false){

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
	echo '<head>';
	echo '	<title>Rilevamento presenze</title>';
	echo '	<link href="style.css" rel="stylesheet" type="text/css">';
	echo '<head>';
	echo '<body>';
	if(!$login){
		
		echo '<h1>UPA - Sistema rilevamento presenze </h1>';

	}

}
	
function html_login($error=""){
	echo '<div id="login"><form method="post" action="index.php">';
	echo '<div id="box"><label class="label_login" for="username">Codice utente:</label> <input type="text" name="username" id="username"/><br />';
	echo '<label class="label_login" for="password">Password:</label> <input type="password" name="password" id="password"/><br />';
	echo '';
	echo '';
	echo '';
	echo '';
	echo '';
	echo '<input type="submit" value="Login!" /><br />';
	echo "$error";
	echo '</div>';

	echo '</form></div>';
}


function html_footer($login=false){
	global $queryNr, $debug;

	if(!$login){
			echo '<br /><br /><br /><a href="index.php">Torna alla home page </a> - ' . $queryNr . ' - <a href="index.php?logout">Logout</a><br />';
		}
	if($debug)echo "$queryNr query eseguite <br />";
	echo '</body>';
	echo '</html>';

}


function selectMese($mesi, $meseShow,  $hidden=""){
	echo '<form action="index.php" id="formdata" method="get">';
	echo 'Mese: <select name="mese" onchange="this.form.submit()">';

	foreach ($mesi as $mese){
		if($mese['value']==$meseShow) echo "<option selected=\"selected\" value='" . $mese['value'] . "' label='" . $mese['label'] . "'>" . $mese['label'] . "</option> ";
		else echo "<option  value='" . $mese['value']."' label='" . $mese['label']."'>" . $mese['label']."</option> ";
	}
	echo "</select>";
	echo $hidden;
	echo '</form>';

}

function selectUtenti($utenti, $utenteShow,  $hidden=""){
	echo '<form action="index.php" id="formdata" method="get">';
	echo 'Mese: <select name="utente" onchange="this.form.submit()">';

	foreach ($utenti as $utente){
		if($utente['value']==$utenteShow) echo "<option selected=\"selected\" value='" . $utente['value'] . "' label='" . $utente['label'] . "'>" . $utente['label'] . "</option> ";
		else echo "<option  value='" . $utente['value']."' label='" . $utente['label']."'>" . $utente['label']."</option> ";
	}
	echo "</select>";
	echo $hidden;
	echo '</form>';

}


function html_utenteDetail($tabella, $utenti, $mesi,  $utenteShow, $meseShow ){
	if(count($tabella)==1){
		echo '<h2> Nessun dato presente per ' . $utenteShow . '</h2> ';
		selectMese   ($mesi, $meseShow ,    "<input type='hidden' name='utente' value='$utenteShow' />");
		selectUtenti ($utenti, $utenteShow, "<input type='hidden' name='mese' value='$meseShow' />");

	}else{
		echo '<h2> Timbrature e anomalie '. $tabella[0]['cognome'].' '. $tabella[0]['nome'].' ('. $tabella[0]['username'].') </h2>';
		selectMese   ($mesi, $meseShow ,    "<input type='hidden' name='utente' value='$utenteShow' />");
		selectUtenti ($utenti, $utenteShow, "<input type='hidden' name='mese' value='$meseShow' />");

		echo '<table border=1> ';
		echo '<tr>';
		echo '<th> Data </th>';	
		echo '<th colspan="12"> Orari di timbratura</th>';	
		echo '</tr>';
		echo '<tr>';

		$tabella2 = Array();
		$maxkey   = cal_days_in_month(CAL_GREGORIAN, substr($meseShow, 4,2), substr($meseShow, 0,4));
		
		foreach ($tabella as $riga)	{
			$tabella2[intval($riga['day'])][]= $riga['ts'];
		}			
		for ($i = 1; $i <= $maxkey; $i++) {
			echo "<tr><td>$i</td>";
			if (!isset ($tabella2[$i] ))continue;
			foreach ($tabella2[$i] as $timbratura){
				echo "<td>$timbratura</td>";
			}
			echo '</tr>';
		}

		echo '</table>';
	}
}


?> 

