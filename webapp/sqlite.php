<?
if(!isset ($config)){ exit(127);}


$db = new SQLite3(DB_FILE);

//prefisso, utile in istanze multiple sullo stesso db, probabilmente utile solo per db più ciccioni
$pre="";


function query($sql){
	global $db, $queryNr, $debug;
	$queryNr=$queryNr+1;
	if($debug) echo "$sql<br />";

	$results = $db->query($sql);
	while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    	$resultArray[]=$row;
	}
	if (isset($resultArray))return $resultArray;
	else return false;
}

function quote($campo, $tipo){
	
	switch ($tipo) {
		case "text":
			return "'".SQLite3::escapeString ( $campo )."'";
		default:
			return SQLite3::escapeString ( $campo );
	}
}
 
?>
