<?php
session_start();

require_once("./connessione.php");

$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

if (isset($_POST["invio"])) {
    $movie_id = $_POST["movie_id"];

    $_SESSION["carrello_movie"][$movie_id] = "Prodotto aggiunto al carrello!";
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mieistili.css">
	<title>Scarica la tua moviea</title>
</head>

<body>
<?php require_once("./menù.php"); ?>
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
		$sql = "SELECT movieId, title, genere, costoMovie FROM $STmovie_table_name";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
			while ($row = $resultQ->fetch_assoc()) {
				echo "<div class=\"prodotti\">
					<h2>" . $row["title"] . "</h2>
					<img style=\"width: 100px\" src=\"logomovie.png\">
					<p>Genere: " . $row["genere"] . "</p>
					<h3>Prezzo: " . $row["costoMovie"] . " €</h3>
					
					<form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
						<input type=\"hidden\" name=\"movie_id\" value=\"" . $row["movieId"] . "\">
						<input class=\"button\" type=\"submit\" name=\"invio\" value=\"Aggiungi al carrello\">
					</form>
					
					<p style= color:red>";

					if (isset($_SESSION["carrello_movie"]) && !empty($_SESSION["carrello_movie"][$row["movieId"]])) {
						echo $_SESSION["carrello_movie"][$row["movieId"]];
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