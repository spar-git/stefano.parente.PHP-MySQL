<?php
session_start();

if (!isset($_SESSION['accessoPermesso']))       // impedisce l'accesso a chi non è iscritto
    header('Location: login.php');
if(isset($_SESSION['accessoPermesso']))         // impedisce l'accesso a chi non è amministratore 
    if ($_SESSION['tipologia']!=2)
        header('Location: login.php');

require_once("./connessione.php");
$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

$esito="";

// AGGIUNTA DEL RECORD NELLA TABELLA MUSICA
if (isset($_POST["aggiungi_musica"])) {
    $titolo = $_POST["title_music"];
    $autore = $_POST["autore_music"];
    $prezzo = $_POST["costo_music"];

    $sql = "INSERT INTO $STmusic_table_name 
    (title, costoMusic, autore) 
    VALUES 
    ('$titolo', '$prezzo', '$autore')";

    if ($resultQ = mysqli_query($mysqliConnection, $sql))
        $esito = ">>>>> Record inserito correttamente! <<<<<";
    else {
        $esito = ">>>>> Impossibile inserire il record <<<<<";
    exit();
    }
}

// AGGIUNTA DEL RECORD NELLA TABELLA MOVIE
if (isset($_POST["aggiungi_movie"])) {
    $titolo = $_POST["title_movie"];
    $genere = $_POST["genere_movie"];
    $prezzo = $_POST["costo_movie"];

    $sql = "INSERT INTO $STmovie_table_name 
    (title, costoMovie, genere) 
    VALUES 
    ('$titolo', '$prezzo', '$genere')";

    if ($resultQ = mysqli_query($mysqliConnection, $sql))
        $esito = ">>>>> Record inserito correttamente! <<<<<";
    else {
        $esito = ">>>>> Impossibile inserire il record <<<<<" . mysqli_error($mysqliConnection);
    exit();
    }
}

// MODIFICA ATTRIBUTO "stato" DEL RECORD NELLA TABELLA USER
if (isset($_POST["ban_unban"])){
    if (isset($_POST["ban_unban_user"])&&isset($_POST["stato_user"])) {
            if ($_POST["stato_user"]) {                           // se non è bannato, fai il ban
                $banUnbanUser = $_POST["ban_unban_user"];
                $sql = "UPDATE $STuser_table_name 
                        SET stato = 0 
                        WHERE userId = $banUnbanUser";
            } else {
                $banUser = $_POST["ban_unban_user"];               // se è bannato, fai l'unban
                $sql = "UPDATE $STuser_table_name 
                        SET stato = 1 
                        WHERE userId = $banUser";
            }
                if ($resultQ = mysqli_query($mysqliConnection, $sql))
                    $esito = ">>>>> Record modificato correttamente! <<<<<";
                else {
                $esito = ">>>>> Impossibile modificare il record <<<<<" . mysqli_error($mysqliConnection);
                exit();
                }
    }
}
// ELIMINAZIONE RECORD DALLA TABELLA UTENTI
if (isset($_POST["elimina"])){
    if (isset($_POST["delete_user"])){
        $userId = $_POST["delete_user"];
        $sql1 = "DELETE FROM $STrecensioni_table_name       /* prima eliminiamo le recensioni associate all'utente */
                WHERE userId = $userId";        
        $sql2 = "DELETE FROM $STuser_table_name             /* poi l'utente stesso */
                WHERE userId = $userId";
        if ($result1 = mysqli_query($mysqliConnection, $sql1)&&$result2 = mysqli_query($mysqliConnection, $sql2)) {
            $esito= ">>>>> Record eliminato correttamente! <<<<<";
        } else {
            $esito = ">>>>> Errore durante l'eliminazione del record <<<<<" . mysqli_error($mysqliConnection);
        }
    // ELIMINAZIONE RECORD DALLA TABELLA MUSICA
    } else if (isset($_POST["delete_music"])){
        $musicId = $_POST["delete_music"];
        $sql = "DELETE FROM $STmusic_table_name 
                WHERE musicId = $musicId";
        if ($result = mysqli_query($mysqliConnection, $sql)) {
            $esito= ">>>>> Record eliminato correttamente! <<<<<";
        } else {
            $esito = ">>>>> Errore durante l'eliminazione del record <<<<<" . mysqli_error($mysqliConnection);
        }
    //ELIMINAZIONE RECORD DALLA TABELLA MOVIE
    } else if (isset($_POST["delete_movie"])) {
        $movieId = $_POST["delete_movie"];
        $sql = "DELETE FROM $STmovie_table_name 
                WHERE movieId = $movieId";
        if ($result = mysqli_query($mysqliConnection, $sql)) {
            $esito= ">>>>> Record eliminato correttamente! <<<<<";
        } else {
            $esito = ">>>>> Errore durante l'eliminazione del record <<<<<" . mysqli_error($mysqliConnection);
        }
    //ELIMINAZIONE RECORD DALLA TABELLA RECENSIONI
    } else if (isset($_POST["delete_recensioni"])) {
        $recensioneId = $_POST["delete_recensioni"];
        $sql = "DELETE FROM $STrecensioni_table_name 
                WHERE recensioniId = $recensioneId";
        if ($result = mysqli_query($mysqliConnection, $sql)) {
            $esito= ">>>>> Record eliminato correttamente! <<<<<";
        } else {
            $esito = ">>>>> Errore durante l'eliminazione del record <<<<<" . mysqli_error($mysqliConnection);
        }        
    }
}


echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="mieistili.css">
	<title>amministratore</title>
</head>
<body>
<?php require_once("./menù.php"); ?>
<hr />

<div> 
    <p class="path"><a href="homePage.php">Home</a> / Amministratore</p>
</div>

<div><p style="color: red"><?php echo "$esito"; ?> </p></div>

<?php
    $sql = "SELECT userId, userName, password, tipologia, stato FROM $STuser_table_name";
    $resultQ = $mysqliConnection->query($sql);
?>
<div>
<h2>Tabella Utenti</h2>
<table class="tabella">
    <thead>
        <tr>
            <th>userId</th>
            <th>userName</th>
            <th>password</th>
            <th>tipologia</th>
            <th>stato</th>
            <th>elimina</th>
            <th>modifica</th>

        </tr>
    </thead>
    <tbody>
    <?php 
    if ($resultQ) {
        while ($row = $resultQ->fetch_assoc()) { 
        echo "<tr>
            <td>" . $row["userId"] ."</td>
            <td>" . $row["userName"] . "</td>
            <td>" . $row["password"] . "</td>
            <td>" . $row["tipologia"] . "</td>";
            if ($row["stato"]==1) 
                echo "<td>" . $row["stato"] ."</td>";
            else
                echo "<td style=\"color:red\">" . $row["stato"] ." !!!</td>";
            echo "<td> 
            <form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
            <input type=\"hidden\" name=\"delete_user\" value=\"" . $row["userId"] . "\">
            <input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
            </td>
            <td> 
            <input type=\"hidden\" name=\"stato_user\" value=\"" . $row["stato"] . "\">
            <input type=\"hidden\" name=\"ban_unban_user\" value=\"" . $row["userId"] . "\">
            <input class=\"button\" type=\"submit\" name=\"ban_unban\" value=\"Ban/Unban\">
            </form> 
            </td>
            </tr>";
        } 
    echo "</tbody>
</table>";
} ?>
</div>

<?php
    $sql = "SELECT musicId, title, costoMusic, autore FROM $STmusic_table_name";
    $resultQ = $mysqliConnection->query($sql);
?>
<div>
<h2>Tabella Musica</h2>
<table class="tabella">
    <thead>
        <tr>
            <th>musicId</th>
            <th>title</th>
            <th>costoMusic</th>
            <th>autore</th>
            <th>elimina</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if ($resultQ) {
        while ($row = $resultQ->fetch_assoc()) { 
        echo "<tr>
            <td>" . $row["musicId"] ."</td>
            <td>" . $row["title"] . "</td>
            <td>" . $row["costoMusic"] . "</td>
            <td>" . $row["autore"] . "</td>
            <td> 
            <form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
            <input type=\"hidden\" name=\"delete_music\" value=\"" . $row["musicId"] . "\">
            <input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
            </form> 
            </td></tr>";
        } 
        echo "</tbody>
        </table>";
} ?>
</div>
<div>
<h2>Aggiungi Musica</h2>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <p>Titolo:<textarea name="title_music" maxlength="50" rows="1" cols="30"></textarea><br></p>
    <p>Costo:<textarea name="costo_music" maxlength="4" rows="1" cols="30"></textarea><br></p>
    <p>Autore:<textarea name="autore_music" maxlength="50" rows="1" cols="30"></textarea><br></p>
    <input class="button" type="submit" name="aggiungi_musica" value="Aggiungi">

</form>
</div>



<?php
    $sql = "SELECT movieId, title, costoMovie, genere FROM $STmovie_table_name";
    $resultQ = $mysqliConnection->query($sql);
?>
<div>
<h2>Tabella Movie</h2>
<table class="tabella">
    <thead>
        <tr>
            <th>movieId</th>
            <th>title</th>
            <th>costoMovie</th>
            <th>genere</th>
            <th>elimina</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if ($resultQ) {
        while ($row = $resultQ->fetch_assoc()) { 
        echo "<tr>
            <td>" . $row["movieId"] ."</td>
            <td>" . $row["title"] . "</td>
            <td>" . $row["costoMovie"] . "</td>
            <td>" . $row["genere"] . "</td>
            <td><form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
            <input type=\"hidden\" name=\"delete_movie\" value=\"" . $row["movieId"] . "\">
            <input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
            </form> 
            </td>
            </tr>";
        } 
    echo "</tbody>
</table>";
} ?>
</div>
<div>
<h2>Aggiungi Movie</h2>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <p>Titolo:<textarea name="title_movie" maxlength="50" rows="1" cols="30"></textarea><br></p>
    <p>Costo:<textarea name="costo_movie" maxlength="4" rows="1" cols="30"></textarea><br></p>
    <p>Genere:<textarea name="genere_movie" maxlength="50" rows="1" cols="30"></textarea><br></p>
    <input class="button" type="submit" name="aggiungi_movie" value="Aggiungi">
</form>
</div>

<?php
    $sql = "SELECT recensioniId, userId, title, descrizione, stelle  FROM $STrecensioni_table_name";
    $resultQ = $mysqliConnection->query($sql);
?>
<div>
<h2>Tabella Recensioni</h2>
<table class="tabella">
    <thead>
        <tr>
            <th>recensioniId</th>
            <th>userId</th>
            <th>title</th>
            <th>descrizione</th>
            <th>stelle</th>
            <th>elimina</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if ($resultQ) {
        while ($row = $resultQ->fetch_assoc()) { 
        echo "<tr>
            <td>" . $row["recensioniId"] ."</td>
            <td>" . $row["userId"] . "</td>
            <td>" . $row["title"] . "</td>
            <td>" . $row["descrizione"] . "</td>
            <td>" . $row["stelle"] . "</td>
            <td> 
            <form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
            <input type=\"hidden\" name=\"delete_recensioni\" value=\"" . $row["recensioniId"] . "\">
            <input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
            </form>
            </td>
            </tr>";
        } 
    echo "</tbody>
</table>";
} ?>
</div>