<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>creazione e popolamento STdb</title></head>

<body>
<h3>creazione e popolazione del database</h3>

<?php	

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
$sqlQuery.= "tipologia int";                      //se 1 utente, se 2 gestore, se 3 admin
$sqlQuery.= "stato boolean";                      //se 1 attivo, se 0 bannato
$sqlQuery.= "sommeSpese float";                   //ricorda la somma di tutte le spese dell'utente 
$sqlQuery.= "puntiFedeltà float";                 //acquisisce punti in base alle spese, possono essere azzerati se utilizzati per lo sconto
$sqlQuery.= ");";                                 

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella utenti creata!!!\n");
else {
    printf("Errore creazione Tabella utenti!\n");
  exit();
}

$sqlQuery = "CREATE TABLE if not exists $STmovie_table_name (";
$sqlQuery.= "movieId int NOT NULL auto_increment, primary key (movieId), ";
$sqlQuery.= "title varchar (50) NOT NULL, ";
$sqlQuery.= "costoMovie float";
$sqlQuery.= "genere varchar (20) NOT NULL,";                            //genere del film
$sqlQuery.= "valutazioneUtenti int";                                    //valutazione complessiva utenti   
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella movie creata!!!\n");
else {
    printf("Errore creazione Tabella utenti!\n");
  exit();
}