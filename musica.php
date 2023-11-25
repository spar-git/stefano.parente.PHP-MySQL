<?php
session_start();

require_once("./setup/connessione.php");
if (!$mysqliConnection->select_db($db_name)) {
    echo "Errore nella selezione del database: " . $mysqliConnection->error;
}

if (isset($_POST["invio"])) {
    $music_id = $_POST["music_id"];

    $_SESSION["carrello_music"][$music_id] = "Prodotto aggiunto al carrello!"; //variabile di sessione (array associativo multidimensionale)
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="style/mieistili.css">
	<title>Scarica la tua musica</title>
</head>

<body>
<?php require_once("./menù.php"); ?>
<hr />

<div> 
    <p class="path"><a href="homePage.php">Home</a> / Musica</p>
</div>

<div>
	<h2>Musica</h2>
</div>

<div>
<div class="box-prodotti">
		<?php
		$sql = "SELECT musicId, title, autore, costoMusic FROM $STmusic_table_name";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
			while ($row = $resultQ->fetch_assoc()) {
				echo "<div class=\"prodotti\">
					<h2>" . $row["title"] . "</h2>
					<img style=\"width: 100px\" src=\"img/logomusic.png\">
					<p>Autore: " . $row["autore"] . "</p>
					<h3>Prezzo: " . $row["costoMusic"] . " €</h3>
					
					<form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
						<input type=\"hidden\" name=\"music_id\" value=\"" . $row["musicId"] . "\">
						<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Aggiungi al carrello\">
					</form>
					
					<p style= color:red>";

					if (isset($_SESSION["carrello_music"]) && !empty($_SESSION["carrello_music"][$row["musicId"]])) {
						echo $_SESSION["carrello_music"][$row["musicId"]];
					}

					echo "</p>
					
					</div>";
				}
				
		} else {
			echo "Errore nella query: " . $mysqliConnection->error;
		}
?>
</body>
</html>