<?php
session_start();

require_once("./connessione.php");
$mysqliConnection = new mysqli("localhost", "root", "pass123", $db_name);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mieistili.css">
	<title>il negozio</title>
</head>

<body>
<?php require_once("./menù.php"); ?>
<hr />

<div> 
    <p class="path"><a href="homePage.php">Home</a> / Negozio</p>
</div>

<div>
	<h2 style="display: inline;">Il negozio</h2>
    <h4 style="font-style: italic;display: inline;">di Media Shop Online</h3>
</div>

<div>
    <p>Siamo appassionati di musica e cinema, e vogliamo condividere con te una vasta selezione di brani musicali, 
        album e film da scaricare. Il nostro obiettivo è rendere l'arte e l'intrattenimento accessibili a tutti. Unisciti 
        a noi nella scoperta di un mondo di emozioni e intrattenimento digitali.
    </p>
</div>

<div class="dove-siamo-box">
    <a href="https://maps.app.goo.gl/ziUegZv8x3ngFcxN7"><img style="width: 220px; float: left; margin-right:20px; margin-bottom:10px;" src="mappa.png" alt="Dove siamo"></a>
    <div style="text-align: justify;">
        <h2 >Dove Siamo</h2>
        <p>La sede di Media Shop Online si trova in Via A. Doria, 23, a Latina. Per raggiungerci, segui le seguenti indicazioni:<br><br></p>
        <ol>
            <li>Dalla stazione ferroviaria di Latina, svoltare a sinistra e camminare per 200 metri.</li>
            <li>Presso l'incrocio di Via A. Doria, svoltare a destra.</li>
            <li>Prosegui per altri 100 metri e troverai la nostra sede sulla sinistra, al numero 23.</li>
        </ol>
        <p>Non esitare a contattarci se hai bisogno di ulteriori informazioni o indicazioni.</p>
    </div>
</div>

<div class="recensioni-box">
    <h2> Cosa dicono di noi</h2>
    <?php
    $recensioni_presenti=false;
    $sql = "SELECT title, descrizione, stelle, userId FROM $STrecensioni_table_name";
    $resultQ = $mysqliConnection->query($sql);

    if ($resultQ) {
        while ($row = $resultQ->fetch_assoc()) {
            $recensioni_presenti=true;
            echo "<div class=\"recensione\">
                <p>Utente: " . $row["userId"] . "</p>
                <p>Valutazione: " . $row["stelle"] . "</p>
                <h3>" . $row["title"] . "</h2>
                <p>" . $row["descrizione"] . "</p>
                
            </div>";
        }
    } else 
        echo "Errore nella query: " . $mysqliConnection->error;
    if (!$recensioni_presenti)
        echo "<p>Non ci sono ancora recensioni del sito...</p>"
    ?>
</div>

</body>
</html>
        

