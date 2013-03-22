 <?
if(!isset ($config)){ exit(127);}

define ('COSTANTE_DATA',        '%%DATA%%');
define ('COSTANTE_USERNAME',    '%%USERNAME%%');
define ('COSTANTE_PASSWORD',    '%%PASSWORD%%');
define ('COSTANTE_ADMINCLAUSE', '%%ADMINCLAUSE%%');

$sqlLogin=("SELECT * from {$pre}utenti  where username= %%USERNAME%% and password=%%PASSWORD%%" );

$sqlGetUtentiDetail="select timestamp, u.username, cognome, nome,  strftime( '%H:%M:%S', datetime( timestamp, 'unixepoch')) as ts, strftime( '%d', datetime( timestamp, 'unixepoch')) as day from utenti as u join rfids as r on u.username=r.username join timbrature as t on r.rfid_number=t.rfid_number where strftime( '%Y%m', datetime( timestamp, 'unixepoch'))= %%DATA%% and r.username =  %%USERNAME%%  ";


$sqlGetListUtenti= "select distinct cognome || ' ' || nome  as label, username as value from utenti as u where 1  %%ADMINCLAUSE%%";

$sqlGetMesi="select distinct strftime( '%Y%m', datetime( timestamp, 'unixepoch')) as value,  strftime( '%m - %Y', datetime( timestamp, 'unixepoch')) as label from utenti as u join rfids as r on u.username=r.username join timbrature as t on r.rfid_number=t.rfid_number  where 1  %%ADMINCLAUSE%%  order by strftime( '%Y%m', datetime( timestamp, 'unixepoch')) desc";


?>
