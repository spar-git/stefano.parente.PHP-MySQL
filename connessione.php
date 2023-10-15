<?php
$db_name = "EcommerceDB";                       //database 
$STuser_table_name = "STuser";                  //tabella utenti
$STmovie_table_name = "STmovie";                //tabella film
$STmusic_table_name = "STmusic";                //tabella musica
$STrecensioni_table_name = "STrecensioni";      //tabella recensioni

//tentativo connessione
$mysqliConnection = new mysqli("localhost", "archer", "archer");      //tentativo connessione

// controllo della connessione
if (mysqli_connect_errno()) {
    printf("Abbiamo problemi con la connessione al db: %s\n", mysqli_connect_error($mysqliConnection));
    exit();
}
?>