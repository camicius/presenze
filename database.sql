create table utenti (username text primary key, password text, cognome text, nome text, admin text);
create table timbrature (rfid_number text, timestamp text, primary key (rfid_number,timestamp));
create table rfids (username text, rfid_number text, primary key (username, rfid_number));
insert into utenti (username, password, cognome, nome, admin) values ('admin', 'admin', 'Admin', 'istrator', 'S');
insert into rfids (username, rfid_number) values ('admin', '24000fe5af');

