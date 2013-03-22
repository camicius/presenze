 <?
if(!isset ($config)){ exit(127);}

function errore($testo){
	//html_errore($testo);
	echo $testo;
	die();

}

function myLog($message, $date=true){
	
	$fh = fopen('/var/log/presenzeUpdate.log', 'a'); 
	if($date) $toWrite=date('Ymd:Hi') . " - "  . $message . "\n";
	else $toWrite= $message . "\n";
	fwrite($fh, $toWrite ); 
	fclose($fh);
}

function verificaPassword($username, $password){
	global $sqlLogin;
	$sql=$sqlLogin;

	$sql=str_replace(COSTANTE_PASSWORD,   quote($password, 'text'), $sql);
	$sql=str_replace(COSTANTE_USERNAME,   quote($username, 'text'), $sql);
	$result=query($sql);
	if(isset($result[0]))return $result[0];
	else return false;

	

}

function pagina(){
	global $meseCorrente, $annoCorrente,  $adminClause;


	if($_SESSION['admin']=='S')  $adminClause= '';
	else $adminClause = "  and u.username = " . quote($_SESSION['username'], 'text')."  ";
	
	$utenteShow = $_SESSION['username'];
	$meseShow   = $annoCorrente.$meseCorrente;
	if(isset ($_GET['utente'])){
		$utenteShow=$_GET['utente'];
	}
	if(isset ($_GET['mese'])){
		$meseShow=$_GET['mese'];
	}
	
	$tabella= getUtentiDetail($utenteShow, $meseShow);
	$utenti = getUtenti();
	$mesi = getMesi();

	html_utenteDetail($tabella, $utenti, $mesi,  $utenteShow, $meseShow );
}


function getUtentiDetail($username, $mese){
	global $sqlGetUtentiDetail;
	$sql=$sqlGetUtentiDetail;
	$sql=str_replace(COSTANTE_DATA,     quote($mese,     'text'), $sql);
	$sql=str_replace(COSTANTE_USERNAME, quote($username, 'text'), $sql);	
	return query($sql);
}



function getUtenti(){
	global $sqlGetListUtenti, $adminClause;
	$sql=$sqlGetListUtenti;
	$sql=str_replace(COSTANTE_ADMINCLAUSE, $adminClause, $sql);	

	return query($sql);

}
function getMesi(){
	global $sqlGetMesi, $adminClause;
	$sql=$sqlGetMesi;
	$sql=str_replace(COSTANTE_ADMINCLAUSE, $adminClause, $sql);	

	return query($sql);

}

?>
