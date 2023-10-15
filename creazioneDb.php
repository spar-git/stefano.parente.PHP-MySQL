<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>creazione e popolamento STdb</title></head>

<body>
<h3>creazione e popolazione del database</h3>

<?php	

require_once("./connessione.php");

// creazione del database
$queryCreazioneDatabase = "CREATE DATABASE $db_name";

if ($resultQ = mysqli_query($mysqliConnection, $queryCreazioneDatabase)) {
    printf("Database creato\n");
}
else {
    printf("Errore di creazione de database!");
    exit();
}

//chiudiamo la connessione
$mysqliConnection->close();

// e la riapriamo con il collegamento alla base di dati
$mysqliConnection = new mysqli("localhost", "archer", "archer", $db_name);

// controllo della connessione (versione "procedurale")
if (mysqli_errno($mysqliConnection)) {
    printf("Abbiamo problemi con la connessione al db: %s\n", mysqli_error($mysqliConnection));
    exit();
}

$sqlQuery = "CREATE TABLE if not exists $STuser_table_name (";                
$sqlQuery.= "userId int NOT NULL auto_increment, primary key (userId), ";
$sqlQuery.= "userName varchar (50) NOT NULL, ";
$sqlQuery.= "password varchar (32) NOT NULL, ";
$sqlQuery.= "tipologia smallint,";                        //se 1 utente, se 2 gestore, se 3 admin
$sqlQuery.= "sommeSpese float,";                          //ricorda la somma di tutte le spese dell'utente
$sqlQuery.= "puntiFedeltà float,";                        //acquisisce punti in base alle spese (possono essere azzerati se utilizzati per lo sconto)
$sqlQuery.= "stato boolean";                             //se 1 attivo, se 0 bannato
$sqlQuery.= ");";                                 

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella utenti creata!!!\n");
else {
    printf("Errore creazione Tabella utenti!\n");
  exit();
}

// CREA TABELLA FILM
$sqlQuery = "CREATE TABLE if not exists $STmovie_table_name (";
$sqlQuery.= "movieId int NOT NULL auto_increment, primary key (movieId), ";
$sqlQuery.= "title varchar (50) NOT NULL, ";
$sqlQuery.= "costoMovie float, ";
$sqlQuery.= "genere varchar (20) NOT NULL, ";    //genere del film
$sqlQuery.= "numVotiMovie bigint, ";                  //numero di voti del film (utile anche per calcolare le stelle)
$sqlQuery.= "stelle smallint";                  //valutazione utenti complessiva del film  
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella movie creata!!!\n");
else {
    printf("Errore creazione Tabella film!\n");
  exit();
}

//CREA TABELLA MUSICA 
$sqlQuery = "CREATE TABLE if not exists $STmusic_table_name (";
$sqlQuery.= "musicId int NOT NULL auto_increment, primary key (musicId), ";
$sqlQuery.= "title varchar (50) NOT NULL, ";
$sqlQuery.= "costoMusic float, ";
$sqlQuery.= "autore varchar (50) NOT NULL, ";             //nome dell'autore del brano
$sqlQuery.= "numVotiMusic bigint,  ";                          ///numero di voti del brano (utile anche per calcolare le stelle) 
$sqlQuery.= "stelle smallint";                            //valutazione utenti complessiva del brano 
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella musica creata!!!\n");
else {
    printf("Errore creazione Tabella musica!\n");
  exit();
}

//CREA TABELLA RECENSIONI DEL SITO
$sqlQuery = "CREATE TABLE if not exists $STrecensioni_table_name (";
$sqlQuery.= "recensioniId int NOT NULL auto_increment, primary key (recensioniId), ";
$sqlQuery.= "title varchar (20), ";              //titolo recensione max 20 char per migliorare la leggibilità
$sqlQuery.= "descrizione varchar (250), ";        //descrizione della recensione limitata a 250 char affinchè non diventi troppo prolissa
$sqlQuery.= "stelle smallint (20) ";            //valutazione utenti complessiva del sito
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella recensioni creata!!!\n");
else {
    printf("Errore creazione Tabella recensioni!\n");
  exit();
}

echo mysqli_errno($mysqliConnection);

//////////////da qui inizia il popolamento delle tabelle////////////////////

// popolamento tabella utenti
$sql = "INSERT INTO $STuser_table_name
	(userName, password, tipologia, sommeSpese, puntiFedeltà, stato)
	VALUES
	(\"stefano\", \"pass123\", \"3\", \"0\", \"0\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
    exit();
}

$sql = "INSERT INTO $STuser_table_name
	(userName, password, tipologia, sommeSpese, puntiFedeltà, stato)
	VALUES
	(\"paolo\", \"pass456\", \"1\", \"0\", \"0\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
  exit();
}

$sql = "INSERT INTO $STuser_table_name
	(userName, password, tipologia, sommeSpese, puntiFedeltà, stato)
	VALUES
	(\"sara\", \"pass789\", \"2\", \"0\", \"0\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
  exit();
}

//popolamento tabella film
$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"Il buono, il brutto, il cattivo\", \"20\", \"Western\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"Metropolis\", \"18\", \"Fantascienza\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"Il padrino\", \"20\", \"Drammatico\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"C'era una volta il west\", \"22\", \"Western\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"Eva contro Eva\", \"25\", \"Drammatico\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere, numVotiMovie, stelle)
	VALUES
	(\"2001: Odissea nello spazio\", \"28\", \"Fantascienza\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

//popolamento tabella musica
$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"Gli anni\", \"4\", \"Max Pezzali\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"Amor mio\", \"2\", \"Mina\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"L'ombelico del mondo\", \"7\", \"Jovanotti\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"La storia siamo noi\", \"4\", \"Francesco De Gregori\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"Sally\", \"6\", \"Vasco Rossi\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"Mentre tutto scorre\", \"3\", \"Negramaro\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore, numVotiMusic, stelle)
	VALUES
	(\"America\", \"5\", \"Gianna Nannini\", \"0\", \"0\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

//niente popolamento tabella recensioni, l'abbiamo creata ma verrà popolata dagli utenti all'occorrenza

mysqli_close($mysqliConnection);
?>
</body></html>