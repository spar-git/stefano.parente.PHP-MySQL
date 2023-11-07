<?php
require_once("./connessione.php");

$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

?>


<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mieistili.css">
	<title>Scarica i tuoi film</title>
</head>

<body>
<?php require_once("./menù.html"); ?>
<hr />

<div> 
    <p class="path"><a href="homePage.php">Home</a> / Film</p>
</div>

<div>
	<h2>Film</h2>
</div>

<div>
	<div class="box-prodotti">
	<?php
		$sql = "SELECT title, genere, costoMovie, stelle, numVotiMovie FROM $STmovie_table_name";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
			while ($row = $resultQ->fetch_assoc()) {
				echo "<div class=\"prodotti\">
					<h2>" . $row["title"] . "</h2>
					<p>Genere: " . $row["genere"] . "</p>
					<p>Numero voti: " . $row["numVotiMovie"] . "</p>
					<p>Valutazione: " . $row["stelle"] . "</p>
					<h3>Prezzo: " . $row["costoMovie"] . " €</h3>
					<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Aggiungi al carrello\">
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