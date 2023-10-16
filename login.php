<?php
require_once("./connessione.php");

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
      $_SESSION['userId']=$row['userId'];
      $_SESSION['tipologia']=$row['tipologia'];     //ce la portiamo nella pagina iniziale per capire i privilegi dell'utente (se 1 utente, se 2 gestore, se 3 admin)
      $_SESSION['sommeSpese']=$row['sommeSpese'];
      $_SESSION['puntiFedeltà']=$row['puntiFedeltà'];
      $_SESSION['accessoPermesso']=1000;

      if ($row['stato']==1) {                 //se TRUE l'utente è attivo e può accedere al sito
        header('Location: homePage.php');    
        exit();
      }
      else {                 //altrimenti l'utente è bannato e non può accedere al sito
        echo "<h1 style=\"color:red; background-color: black; padding: 4ex;\"> !!! Sei stato bannato dal sito dall&lsquoadmin. Pertanto non potrai pi&uacute accederne al contenuto !!!</h1>";
      }
    }
    else
    echo "<p>I dati inseriti non sono corretti, ritenta.</p>";           //caso in cui i dati inseriti non sono corretti 
  }
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>pagina di login</title>
</head>

<body>
<h1 style="color:red; text-align: center; border: solid;" > Benvenuto su MediaShop Online!</h1>
<hr />
<h3 style="text-align:center; margin-top: 20px;  font-family: Arial, sans-serif;">Accedi inserendo nome utente e password<h3>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
<h4>
  username: <input style="padding: 2ex;" type="text" name="userName" size="25" />
  password: <input style="padding: 2ex;" type="text" name="password" size="25" />

  <input type="submit" name="invio" value="accedi">
  <input type="reset" name="reset" value="reset">
</h4>

</form>

</body>
</html>