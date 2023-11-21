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
$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

// controllo della connessione (versione "procedurale")
if (mysqli_errno($mysqliConnection)) {
    printf("Abbiamo problemi con la connessione al db: %s\n", mysqli_error($mysqliConnection));
    exit();
}

// CREA TABELLA UTENTI
$sqlQuery = "CREATE TABLE if not exists $STuser_table_name (";                
$sqlQuery.= "userId int NOT NULL auto_increment, primary key (userId), ";
$sqlQuery.= "userName varchar (50) NOT NULL, ";
$sqlQuery.= "password varchar (32) NOT NULL, ";
$sqlQuery.= "tipologia smallint,";                        //se 1 utente, se 2 admin
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
$sqlQuery.= "genere varchar (20) NOT NULL";    //genere del film 
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
$sqlQuery.= "autore varchar (50) NOT NULL";             //nome dell'autore del brano
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
$sqlQuery .="userId int NOT NULL, ";
$sqlQuery.= "title varchar (20), ";              //titolo recensione max 20 char per migliorare la leggibilità
$sqlQuery.= "descrizione varchar (250), ";        //descrizione della recensione limitata a 250 char affinchè non diventi troppo prolissa
$sqlQuery.= "stelle smallint, ";            //valutazione utenti complessiva del sito
$sqlQuery .= "FOREIGN KEY (userId) REFERENCES $STuser_table_name(userId)";
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
	(userName, password, tipologia, stato)
	VALUES
	(\"stefano\", \"pass123\", \"2\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
    exit();
}

$sql = "INSERT INTO $STuser_table_name
	(userName, password, tipologia, stato)
	VALUES
	(\"paolo\", \"pass456\", \"1\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
  exit();
}

$sql = "INSERT INTO $STuser_table_name
	(userName, password, tipologia, stato)
	VALUES
	(\"sara\", \"pass789\", \"1\", \"1\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento user eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STuser.\n");
  exit();
}

//popolamento tabella film
$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"Il buono, il brutto, il cattivo\", \"20\", \"Western\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"Metropolis\", \"18\", \"Fantascienza\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"Il padrino\", \"20\", \"Drammatico\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"C'era una volta il west\", \"22\", \"Western\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"Eva contro Eva\", \"25\", \"Drammatico\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

$sql = "INSERT INTO $STmovie_table_name
	(title, costoMovie, genere)
	VALUES
	(\"2001: Odissea nello spazio\", \"28\", \"Fantascienza\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento movie eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmovie.\n");
  exit();
}

//popolamento tabella musica
$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"Gli anni\", \"4\", \"Max Pezzali\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"Amor mio\", \"2\", \"Mina\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"L'ombelico del mondo\", \"7\", \"Jovanotti\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"La storia siamo noi\", \"4\", \"Francesco De Gregori\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"Sally\", \"6\", \"Vasco Rossi\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"Mentre tutto scorre\", \"3\", \"Negramaro\")
	";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Polamento music eseguito!!!\n");
else {
    printf("Impossibile popolare tabella STmusic.\n");
  exit();
}

$sql = "INSERT INTO $STmusic_table_name
	(title, costoMusic, autore)
	VALUES
	(\"America\", \"5\", \"Gianna Nannini\")
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