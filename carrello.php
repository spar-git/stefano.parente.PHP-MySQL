<?php
session_start();

require_once("./connessione.php");
$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

$totale=0;

if (isset($_POST["invio"])){
	if (isset($_POST["id_music"])){
		$id_music= $_POST["id_music"];
		unset($_SESSION['carrello_music'][$id_music]);
	} else {
		$id_movie= $_POST["id_movie"];
		unset($_SESSION['carrello_movie'][$id_movie]);
	}
}

if (isset($_POST["acquista"])){
	unset($_SESSION['carrello_music']);
	unset($_SESSION['carrello_movie']);
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mieistili.css">
	<title>Carrello della spesa</title>
</head>

<body>
<?php require_once("./menù.php"); ?>
<hr />

<div> 
    <p class="path"><a href="homePage.php">Home</a> / Carrello</p>
</div>
<div>
	<h2>Carrello</h2>
</div>

<div class="cart_list">

<?php
if (empty($_SESSION["carrello_music"])&&(empty($_SESSION["carrello_movie"]))){
	echo "<div><p class=\"title\">Il carrello è vuoto</p></div>";
}
if (!empty($_SESSION["carrello_music"])) {
    foreach ($_SESSION["carrello_music"] as $music_id => $messaggio) {
		$sql = "SELECT musicId, title, autore, costoMusic FROM $STmusic_table_name WHERE musicId = $music_id";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
				$row = $resultQ->fetch_assoc();
				echo "<div>
					<p>
					<img style=\"width: 30px\" src=\"logomusic.png\">
					<span class=\"title\">" . $row["title"] ."</span> 
					<span class=\"price\">" . $row["costoMusic"] . " €</span>
					<form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
						<input type=\"hidden\" name=\"id_music\" value=\"" . $music_id . "\">
						<input class=\"button\" type=\"submit\" name=\"invio\" value=\"X\">
					</form>
					</p></div>";
					$totale+=$row["costoMusic"];
		} else {
			echo "Errore nella query: " . $mysqliConnection->error;
		}
	}
}
if (!empty($_SESSION["carrello_movie"])) {
    foreach ($_SESSION["carrello_movie"] as $movie_id => $messaggio) {
		$sql = "SELECT movieId, title, genere, costoMovie FROM $STmovie_table_name WHERE movieId = $movie_id";
		$resultQ = $mysqliConnection->query($sql);

		if ($resultQ) {
				$row = $resultQ->fetch_assoc();
				echo "<div>
					<p>
					<img style=\"width: 30px\" src=\"logomovie.png\">
					<span class=\"title\">" . $row["title"] ."</span> 
					<span class=\"price\">" . $row["costoMovie"] . " €</span>
					<form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
						<input type=\"hidden\" name=\"id_movie\" value=\"" . $movie_id . "\">
						<input class=\"button\" type=\"submit\" name=\"invio\" value=\"X\">
					</form>
					
					</p></div>";
					$totale+=$row["costoMovie"];
		}
	}
}
?>

<div>
	<p>
		<span class="totale"><strong>Totale</strong></span> 
		<span class="price"><strong><?php echo $totale; ?> €</strong></span>
		<?php if ($totale>0) { ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input class="button" type="submit" name="acquista" value="Acquista">
		</form>
		<?php } ?>
	</p>
</div>




</div>
			
</body>
</html>