<?php
require_once("./connessione.php")

if (isset($_POST['invio']))                                         //è stato dato l'invio?...    
  if (empty($_POST['userName']) || empty($_POST['password']))       //...sono stati inseriti username e password?
    echo "<p>dati mancanti!</p>";
  else {                                                            //se si, allora cerchiamo l'utente nel DB
    $sql = "SELECT *                                                
            FROM $STuser_table_name             
            WHERE userName = \"{$_POST['userName']}\" AND password =\"{$_POST['password']}\"
		    ";
    if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
        printf("La query non ha risultato!\n");
    exit();
    }

    $row = mysqli_fetch_array($resultQ);        //salviamo la riga della tabella in questa variabile

    if ($row) {                                 //se la riga selezionata esiste attiviamo la sessione per ricordare i dati dell'utente (lato server + il cookie di sessione lato client)
      session_start();
      $_SESSION['userName']=$_POST['userName'];
      $_SESSION['dataLogin']=time();
      $_SESSION['numeroUtente']=$row['userId'];
      $_SESSION['spesaFinora']=$row['sommeSpese'];
      $_SESSION['accessoPermesso']=1000;

      header('Location: paginaIniziale.php');    // ....e accediamo alla pagina iniziale
      exit();
    }
    else
    echo "<p>I dati inseriti non sono corretti!!</p>";             //caso in cui i dati inseriti non sono corretti 
  }