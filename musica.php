<?php
session_start();

require_once("./connessione.php");

$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mieistili.css">
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
		$sql = "SELECT title, autore, costoMusic FROM $STmusic_table_name";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
			while ($row = $resultQ->fetch_assoc()) {
				echo "<div class=\"prodotti\">
					<h2>" . $row["title"] . "</h2>
					<p>Autore: " . $row["autore"] . "</p>
					<h3>Prezzo: " . $row["costoMusic"] . " €</h3>
					<form method=\"post\" action=\"gestione_carrello.php\">
						<input type=\"hidden\" name=\"musicId\" value=\"" . $row["musicId"] . "\">
						<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Aggiungi al carrello\">
					</form>
				</div>";
			}
		} else {
			echo "Errore nella query: " . $mysqliConnection->error;
		}
		?>
	</div>
</div>

</body>
</html>