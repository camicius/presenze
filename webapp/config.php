<?
//error_reporting(E_ALL);
$config="ok";
/*
	Dati di connessione al db e a ldap
*/
define('DB_FILE',   '/var/log/presenze.sqlite');



/*
impostazioni e variabili di default
*/
date_default_timezone_set('Europe/Rome');


$date=mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$annoCorrente=date('Y',$date);
$meseCorrente=date('m',$date);

$dayArray=Array(
	1=>'lun',
	2=>'mar',
	3=>'mer',
	4=>'gio',
	5=>'ven',
	6=>'sab',
	7=>'dom');

/*
	importazione librerie di accesso al db
*/
require_once 'MDB2.php';

/*
	importazione libreria di query e di file accessori
*/
require_once 'sqlite.php';
require_once 'sql.php';
require_once 'html.php';
require_once 'funzioni.php';

/*
	numero di query
*/
$queryNr=0;


$debug=false;
/*
	importazione libreria per il caching
*/
#require_once('Cache/Lite.php');
#require_once "Cache/Lite/Output.php";
// Cache_lite option
#$CLoptions = array(
#    'cacheDir' => '/tmp/',
#    'lifeTime' => 36000,
#    'pearErrorMode' => CACHE_LITE_ERROR_DIE
#);
// 
#$cl = new Cache_Lite_Output($CLoptions);




?>

