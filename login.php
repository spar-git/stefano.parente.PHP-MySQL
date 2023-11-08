<?php
require_once("./connessione.php");

$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

$messaggio="";
$submit= "<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Accedi\">
          <input class=\"button\" type=\"submit\" name=\"registrati\" value=\"Registrati\">";
$inputpass = "";

// ACCESSO
if (isset($_POST['invio'])) {                                        //è stato dato l'invio?    
  if (empty($_POST['userName']) || empty($_POST['password'])){      //...sono stati inseriti username e password?
    $messaggio = "Devi inserire entrambi i campi per poter accedere.";     //se no, manda messaggio errore                                  
  }                                                           
  else {                                                            //se si, allora cerchiamo l'utente nel DB
    $sql = "SELECT *                                                
            FROM $STuser_table_name             
            WHERE userName = \"{$_POST['userName']}\" AND password =\"{$_POST['password']}\"
		    ";

    if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
      printf("La query non ha risultato!\n");
    }

    $row = mysqli_fetch_array($resultQ);        //salviamo la riga della tabella in questa variabile

    if ($row) {                                 //se la riga selezionata esiste attiviamo la sessione per ricordare i dati dell'utente (lato server + il cookie di sessione lato client)
      session_start();
      $_SESSION['userName']=$_POST['userName'];
      $_SESSION['userId']=$row['userId'];
      $_SESSION['tipologia']=$row['tipologia'];     //ce la portiamo nella pagina iniziale per capire i privilegi dell'utente (se 1 utente, se 2 gestore, se 3 admin)
      $_SESSION['sommeSpese']=$row['sommeSpese'];
      $_SESSION['puntiFedeltà']=$row['puntiFedeltà'];
      // $_SESSION['stato']=$row['stato'];          //non ci serve dopo, ma solo qui nel login per controllare l'utente
      $_SESSION['dataLogin']=time();
      $_SESSION['accessoPermesso']=1000;

      if ($row['stato']==1) {                 //se TRUE l'utente è attivo e può accedere al sito...
        header('Location: homePage.php');    
        exit();
      }
      else {                                //...altrimenti l'utente è bannato e non può accedere al sito
        $messaggio ="!!! Sei stato bannato dal sito dall'admin. Pertanto non potrai pi&uacute accedere ai vantaggi!!!";
      }
    }
    else
      $messaggio = "I dati inseriti non sono corretti, ritenta o registrati.";           //caso in cui i dati inseriti non sono corretti 
  }
}

// REGISTRAZIONE
if (isset($_POST['registrati'])||isset($_POST['registrati2'])) {
  $inputpass = "Conferma Password: <br><input style=\"padding: 2ex;\" type=\"password\" name=\"password2\" size=\"25\" /> <br>";
  $submit= "<input class=\"button\" type=\"submit\" name=\"registrati2\" value=\"Registrati\">";

  if (isset($_POST['registrati2'])){
    if (!empty($_POST['password'])&&!empty($_POST['password2'])&&!empty($_POST['userName'])){
      $sql = "SELECT *                                                
            FROM $STuser_table_name             
            WHERE userName = '{$_POST['userName']}'
		    ";

      if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
        printf("La query non ha risultato!\n");
        exit();
      }

      $row = mysqli_fetch_array($resultQ);        //salviamo la riga della tabella in questa variabile
    
      if ($row) {    
        if ($row['userName']) {                  //se esiste già un nome utente uguale
          $messaggio= "Questo nome utente risulta già registrato!";
        }
      }
      else {
        if (($_POST['password'])==($_POST['password2'])) {

          $sql = "INSERT INTO $STuser_table_name
	              (userName, password, tipologia, sommeSpese, puntiFedeltà, stato)
	              VALUES ('{$_POST['userName']}', '{$_POST['password']}', '1', '0', '0', '1')
	              ";
          if (!$resultQ = mysqli_query($mysqliConnection, $sql)){
          printf("Impossibile popolare tabella STuser.\n");
          exit();
          }
       
          $submit="<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Accedi\">
                <input class=\"button\" type=\"submit\" name=\"registrati\" value=\"Registrati\">";
          $inputpass = "";
          $messaggio="Ti sei registrato correttamente! accedi per verificare";
      }
      else
        $messaggio = "Le due password non corrispondono.";
    }      
  }
  else 
      $messaggio = "Alcuni campi risultano mancanti.";
  }
}
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="mieistili.css">
  <title>pagina di login</title>
</head>

<body>
<?php require_once("./menù.php"); ?>
<hr />
<p style="text-align:center;color: red; font-family: Helvetica, sans-serif;">Unisciti a noi per iniziare a guadagnare punti fedeltà e sbloccare 
fantastici sconti!<br>La registrazione è semplice, non perdere l'opportunità di 
risparmiare sui tuoi acquisti preferiti!</p>

<div style="text-align: center;background-color: #e2e2e2;padding: 5px; border: 1px solid #d05aff; 
            border-radius: 5px;  margin-right: 350px;  margin-left: 350px;">
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <p>
    Username: <br>
    <input style="padding: 2ex;" type="text" name="userName" size="25" /> <br>
    Password: <br>
    <input style="padding: 2ex;" type="password" name="password" size="25" /> <br>
    <?php echo $inputpass ?>
  </p>
  <p><?php echo $submit ?></p>
</div>
</form>

<p style="text-align: center; margin-top: 20px; color:red; text-decoration: underline;font-style: italic;">
<strong> <?php echo $messaggio; ?> </strong>
</p>

</body>
</html>