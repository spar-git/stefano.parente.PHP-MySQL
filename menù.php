<?php
if (isset($_GET['logout']) && $_GET['logout'] == 1) {     // tale condizione sarà verà quando l'utente premerà il tasto "Logout"
    unset($_SESSION);
    session_destroy();
}
?>

<div class="menu-container">
    <nav class="menu">
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
        </div>
        <ul class="menu-list">
            <li><a href="homePage.php">Home</a></li>
            <li><a href="musica.php">Musica</a></li>
            <li><a href="film.php">Film</a></li>
            <li><a href="negozio.php">Negozio</a></li>
            <?php
            if (isset($_SESSION['tipologia'])) { 
                if ($_SESSION['tipologia']==2){
                    echo "<li><a style=\"color: red;\" href=\"amministratore.php\">>>Gestisci Database<<</a></li>";
                }
            }
            ?>
        </ul>
        <div class="user-menu">
            <?php
                if (!isset($_SESSION['accessoPermesso'])){                             //vera nel caso in cui non si abbia effettuato l'accesso
                    echo "<a class=\"login\" href=\"login.php\">Login</a>";}
                else {                                                                 //vera nel caso in cui si abbia effettuato l'accesso
                    echo "<a class=\"login\" href=\"login.php?logout=1\">Logout</a>";  //viene iniettata una query string di tipo GET per cancellare la sessione
                }
            ?>
            <a class="cart" href="carrello.php">Carrello</a>
        </div> 
    </nav>
</div>
<div style="height: 150px; width: 100%;"></div>
