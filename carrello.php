<?php
session_start();

require_once("./connessione.php");
$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

$totale=0;
$flag=0;

if (isset($_POST["elimina"])){
	if (isset($_POST["id_music"])){
		$id_music= $_POST["id_music"];
		unset($_SESSION['carrello_music'][$id_music]);
	} else {
		$id_movie= $_POST["id_movie"];
		unset($_SESSION['carrello_movie'][$id_movie]);
	}
}

if (isset($_POST["invia_recensione"])){
	$flag=1;
	$sql = "INSERT INTO $STrecensioni_table_name
	(userId, title, descrizione, stelle)
	VALUES
	('{$_SESSION['userId']}', '{$_POST["titolo"]}', '{$_POST["descrizione"]}', '{$_POST["stelle"]}')
	";
	if (!$resultQ = mysqli_query($mysqliConnection, $sql)){
    	printf("Impossibile popolare tabella STrecensioni.\n");
    	exit();
	} else {
		$valutazione=$_POST["stelle"];
		echo "$valutazione";
		
		if ($valutazione>3) 
			$valutazione= "Fantastico! Siamo lieti che tu abbia apprezzato il nostro lavoro, a presto!";
		
		if ($valutazione<=3)
			$valutazione= "Siamo spiacenti per la tua esperienza negativa. Segnalaci il tuo problema a info@msonline.it e proveremo ad aiutarti!";  
		
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
<?php
/* -------------- si giunge qui solo dopo aver premuto "Acquista"--------------------*/
if (isset($_POST["acquista"])){
	echo "<div><h1 style=\"color: green\">Grazie per aver acquistato dal nostro sito!</h1>";
	$flag=1;
	if(isset($_SESSION["userId"])) {
	echo "Lascia una recensione"; 
	?>	
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    		<p>stelle:
    		<input type="radio" name="stelle" value="1"> 1
    		<input type="radio" name="stelle" value="2"> 2
    		<input type="radio" name="stelle" value="3"> 3
    		<input type="radio" name="stelle" value="4"> 4
    		<input type="radio" name="stelle" value="5"> 5
			</p>
			<p>Titolo: <textarea name="titolo" maxlength="20" rows="1" cols="30"></textarea><br></p>
			<p>Descrizione:<br><textarea name="descrizione" maxlength="250" rows="4" cols="100"></textarea><br></p>
			<input class="button" type="submit" name="invia_recensione" value="Invia recensione">
		</form>
	<?php
	}
	echo "</div>";
	

	unset($_SESSION['carrello_music']);     
	unset($_SESSION['carrello_movie']);
	$totale=0;	//arrivati qui verrà cancellato il carrello e quindi le istruzioni successive non visualizzeranno nulla
}
if (isset($_POST["invia_recensione"])) {
	$flag=1;
	echo "<div><h2 style=\"color: green\">" . $valutazione . "</h2></div>";
}
?>

<div class="cart_list">


<?php
/*--------------------si giunge qui durante la normale navigazione del sito------------ */
if (empty($_SESSION["carrello_music"])&&(empty($_SESSION["carrello_movie"]))&&$flag!=1){
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
						<input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
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
						<input class=\"button\" type=\"submit\" name=\"elimina\" value=\"X\">
					</form>
					
				</p></div>";
					$totale+=$row["costoMovie"];
		}
	}
}

if ($flag!=1){

echo "<div><p>
		<span class=\"totale\"><strong>Totale</strong></span>";
		$sconto=1;
		if (isset($_SESSION['puntiFedeltà'])){
			if ($_SESSION['puntiFedeltà']>=20){
				$sconto=0.80;
				echo "<span class=\"price\"><strong><strike>" . $totale . " €</strike></strong><strong>" . $totale*$sconto . " €</strong></span>";
			} else {
				echo" <span class=\"price\"><strong>" . $totale . " €</strong></span>";
			}
		} else {
		echo "<span class=\"price\"><strong>" . $totale . " €</strong></span>";
		}
		if ($totale>0) { 
		echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"post\">
			<input class=\"button\" type=\"submit\" name=\"acquista\" value=\"Acquista\">
		</form>";
		}
} 
?>
</p></div>
</div>
			
</body>
</html>