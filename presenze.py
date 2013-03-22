import time
import serial
import datetime
import os   
import sqlite3

#########################
#                       #
#    configurazioni     #
#                       #
#########################
logfilename = '/var/log/presenze.csv'
dbfilename = '/var/log/presenze.sqlite'
porta='/dev/ttyACM0'
pidfile='/var/run/presenze.pid'



#########################
#                       #
# fine configurazioni   #
#                       #
#########################

#funzione per portare a demone il tutto
def daemonize():

	if os.fork(): # launch child and...
		os._exit(0) # kill off parent
	os.setsid()

	if os.fork(): # launch child and...
		os._exit(0) # kill off parent again.
	os.umask(077)
	null=os.open('/dev/null', os.O_RDWR)
	for i in range(3):
		try:
			os.dup2(null, i)
		except OSError, e:
			if e.errno != errno.EBADF:
				raise
				os.close(null)
	
#controllo presenza e consistenza database
if (not os.path.isfile(dbfilename)):
    print "database " + dbfilename + " does not exists!"
    exit(127)
#tento una select sul db per controllare che tutte le tabelle esistano e siano a posto 
conn = sqlite3.connect(dbfilename)
c = conn.cursor()
c.execute('select count(*) from utenti as u join rfids as r on u.username=r.username join timbrature as t on r.rfid_number=t.rfid_number')
conn.close()

                                                                                                                                                                                
#definizione e apertura porta usb
ser = serial.Serial(port=porta, baudrate=9600, bytesize=8, parity='N', stopbits=1, timeout=None, xonxoff=0, rtscts=0)
ser.open()
ser.isOpen()



#mando a demone il tutto
daemonize()    
         



 # controllo istanze attive
if os.path.isfile(pidfile):
	if os.path.isdir('/proc/' + str(file(pidfile,'r').read())):
		print "Main: probabile ci sia un'altra istanza gia' in esecuzione di Presenze. Se cosi' non fosse, elimina ",pidfile
		exit(-1)
	else:
		print "Main: stale pidfile rimosso."
file(pidfile,'w').write(str(os.getpid()))






#apertura file di output


rfid=""   






#ciclo principale:
# - legge una riga dalla seriale
# - scrive una riga sul log con il timestamp
# - apre una connessione al db, scrive la riga nella tabella "timbrature" e chiude la connessione al db

while 1 :
	
	try:
#	legge una riga dalla seriale (che poi e la usb)

		rfid = ser.readline()
		rfid = rfid.strip()
#   rimuove caratteri strani restituiti es. 0x02 e 0x03
		rfid = rfid.replace('\x02','')
		rfid = rfid.replace('\x03','') 
		rfid = rfid.replace('-','') 
		if (rfid=='>'): continue
		if (rfid==''): continue
		now = datetime.datetime.now()  
		stringa = rfid + ";" + str(time.mktime(now.timetuple())) + ";" + str(now.year) + ";" + str(now.month) + ";" + str(now.day) + ";" + str(now.hour) + ";" + str(now.minute) + ";" + str(now.second)
		print stringa
#	apre il file, scrive la stringa e poi lo chiude. Diligentemente.
		presenze = open(logfilename, "a", 0)
		presenze.write(stringa)
		presenze.close()
	except:
		print "continuiamo, si sa mai..."
#	la scrittura sul db e' dentro un try. Se non funziona il programma non schianta...
	try:
		conn = sqlite3.connect(dbfilename)
		c = conn.cursor()
		data= (rfid, str(time.mktime(now.timetuple())))
		c.execute('insert into timbrature (rfid_number, timestamp) values(?,?)', data)
		conn.commit()
		conn.close()
	except:
		print "do nothing...."


ser.close()
exit()
