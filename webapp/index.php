<?
require_once('config.php');

html_header();

session_start();

if (isset($_GET['logout'])){
	unset($_SESSION['username']);
	html_login();
}

else if(isset($_SESSION['username'])){
	/* 
		Se sono io ad essere loggato attivo il debug
	*/
	if($_SESSION['username']=="occhi")$debug=true;
	//sono loggato!

	$username=$_SESSION['username'];

	/*$cacheId=md5("presenze" . $_SERVER['QUERY_STRING']);
	if (!($cl->start($cacheId))){
		pagina();
		$cl->end();
	}*/
	pagina();
}else if (isset($_POST['username']) && isset($_POST['password'])){
	//verifica la password 
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	$ok=verificaPassword($username, $password);
	
	//echo "password ok! <BR> <BR>";
	if(isset($ok['username'])){
		$_SESSION['username']   = $ok['username'];
		$_SESSION['admin']      = $ok['admin'];
		pagina();	

		
	}else{
		html_login("Username o password errata!");
	}

}else{
	html_login();
}

html_footer(!isset($_SESSION['username']));



require_once('debriefing.php');
?>
