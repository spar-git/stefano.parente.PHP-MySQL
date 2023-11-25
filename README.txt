Homework PHP/MYSQL di Stefano Parente matricola 1574482. L'indirizzo del mio repository Github è 
https://github.com/spar-git/stefano.parente.PHP-MySQL

Questo homework è stato sviluppato sulla base dell'esercizio "carrello.della.spesa3"; l'idea è stata quella di approfondire la gestione del database,
implementando script php per la corretta interrogazione dello stesso. L'aspetto grafico non è stato trascurato, ho voluto inserire regole di stile esterne 
("mieistili.css") ed interne (inline style), affinchè l'interfaccia risultasse gradevole e in molti contesti dinamica.

- Installazione. Per il corretto setup del database accedere al codice sorgente del file denominato "connessione.php" e modificare nome utente e password 
(riga 9) con le credenziali corrispondenti al proprio ambiente MySQL. Dopo aver effettuato le modifiche, salvare il file ed inserire la directory nel proprio 
server locale. Una volta completata questa operazione, è possibile accedere al progetto tramite il browser web. Per avviare l'installazione effettiva del database, 
è sufficiente accedere al file "creazioneDb.php". Questo file non solo permetterà la creazione del database, ma si occuperà anche di un parziale popolamento 
dello stesso.

- Da dove accedere. L'accesso al sito web può avvenire da qualsiasi pagina, in quanto visitabile anche da utenti non registrati. D'altra parte la registrazione è
disponibile e permette all'utente di poter recensire la sua esperienza d'acquisto. Viene fatta eccezione per il file "amministratore.php" riservato 
esclusivamente all'amministratore tramite apposito codice di controllo.

- menù.php. Questa pagina è stata creata per semplificare l'inclusione del menù in tutte le pagine del sito. Seppur apparentemente statica, è presente 
l'istruzione che permette la chiusura/distruzione della sessione durante il logout. Fondamentalmente ho deciso di iniettare manualmente una query string di tipo
GET direttamente nell'URL di reindirizzamento al login quando l'utente preme "logout" (riga 31). Quando questa stringa viene inviata, la pagina stessa "menù.php" 
la ottiene e scatena la chiusura/distruzione della sessione in corso. Riapparirà a questo punto il tasto "login". Inoltre, non meno importante, incorpora la 
verifica che l'utente sia o meno l'amministratore (if($_SESSION['tipologia']==2)), in caso di esito positivo apparirà nel menù anche una voce speciale riservata
alla gestione del database.        

- login.php. L'utente può effettuare l'accesso, ma anche registrarsi. L'utente potrà effettuare l'accesso solo se: ha inserito entrambi i campi, è presente nel 
database, risulta attivo (non bannato). Queste condizioni effettuano interrogazioni al database e in caso di esito negativo, viene restituito il corrispondente 
messaggio di avviso. Quando invece l'utente vuole registrarsi, nella pagina apparirà una nuova casella di input denominata "Conferma password" e l'utente potra 
registrarsi solo se: i campi sono stati tutti compilati, le due password coincidono, non è già presente un nome utente uguale al suo nel database. Anche qui, in 
caso di esito negativo viene visualizzato il messaggio di avviso corrispondente e avvengono interrogazioni al database in base ai campi di input inseriti 
dall'utente. Quando l'utente accede, viene avviata la sessione e vengono salvate le relative variabili di sessione necessarie alla navigazione nel sito come 
utente registrato.              >>> per accedere come admin: USERNAME = stefano, PASSWORD = pass123 <<<

- homePage.php. Forse la meno entusiasmante, in quanto completamente statica. E' stato incluso del testo, delle immagini e qualche regola di stile per 
renderla più vivace. 

- musica.php e film.php. Queste sono due pagine quasi gemelle, relative ai prodotti in vendita sul sito. Tramite una SELECT viene selezionata la tabella 
"Stmusic" (o "STmovie") che, attraverso comandi iterativi, viene scandita riga per riga (while ($row = $resultQ->fetch_assoc())). Ogni iterazione genera un 
riquadro che visualizza le informazioni del prodotto selezionato. Quando l'utente aggiunge al carrello un prodotto, viene inviato un input di tipo hidden ed
apparirà un messaggio dell'avvenuta aggiunta proprio nel medesimo riquadro; per ottenere quest'effetto, sono state utilizzate delle variabili di sessione con 
duplice finalità: la prima proprio quella di consentire l'apparizione del messaggio nel riquadro dell'articolo, la seconda quella di poter salvare in qualche 
maniera l'id dell'articolo aggiunto al carrello e poterlo poi ricevere, in qualsiasi momento della navigazione, all'interno della pagina "carrello.php". In 
particolare, definirei la struttura di sessione utilizzata come un'array associativo multidimensionale, dove la prima chiave rappresenta la categoria dei 
prodotti selezionati (musica o film) mentre la seconda chiave rappresenta il loro id nel database.

- negozio.php. Seppur la prima parte risulti statica, costituita infatti da elementi html e regole di stile, in fondo alla pagina è possibile osservare 
un messaggio riferito all'assenza di commenti da parte degli utenti. Quando un'utente registrato acquista dallo shop, potrà recensire la sua esperienza 
d'acquisto. Scomparirà il messaggio e apparirà in quell'area il suo commento, visibile a chiunque navighi nel sito, utenti registrati e non. Un utente non 
registrato non potrà recensire il sito. Anche in questo contesto avvengono interrogazioni al database tramite una SELECT che cerca eventuali commenti nella 
tabella "STrecensioni" e tramite comandi iterativi le visualizza in fondo alla pagina con opportuna formattazione e impaginazione. La tabella "STrecensioni"
presenta una chiave esterna legata all'id dell'utente, questo fa si che ogni recensione sia associata necessariamente ad un'utente registrato e quindi che 
l'amministratore possa effettivamente intervenire sull'utente (ban) responsabile di eventuali recensioni indesiderate.

- carrello.php. In questo contesto vengono all'effettivo usate le variabili di sessione salvate durante l'aggiunta dei prodotti al carrello, se non sono presenti
verrà restituito il relativo avviso. Qualora esistano le variabili di sessione inerenti al carrello_music e/o al carrello_movie, verrà scandito il rispettivo 
array multidimensionale e letta la sua seconda chiave (relativa all'id del prodotto aggiunto al carrello) al fine di individuare i prodotti aggiunti al carrello
dall'utente. L'interrogazione al database è comunque necessaria per prelevare le informazioni del prodotto stesso. Ogni prodotto nel carrello sarà elencato ed 
identificato da una piccola icona di categoria, dal titolo e dal prezzo. Sarà presente anche un pulsante di eliminazione, supportato da un input di tipo 
hidden, che cancellerà la variabile di sessione associata a quel prodotto. Qualora l'utente risulti registrato e proceda all'acquisto, gli verrà proposto di 
lasciare una recensione con apposita form con input di tipo radio, per la valutazione, e di tipo text-area, per il titolo e la descrizione. All'invio della 
recensione apparirà un messaggio in relazione alla valutazione dell'utente.

- amministratore.php. Pagina riservata all'amministratore, dedicata alla gestione del database. Le tabelle vengono popolate attraverso una SELECT ed istruzioni 
iterative che incrementano il loro popolamento riga per riga. Questa tecnica è stata usata in contesti simili in altre pagine del sito, permette di creare 
strutture flessibili in base al numero di elementi da visualizzare. L'amministratore, attraverso appositi pulsanti, può intervenire sul database usufruendo di
un'interfaccia grafica semplice ed intuitiva. L'eliminazione dei record è prevista per ogni tabella, ma nello specifico contesto della tabella utenti è stato
implementato un codice differente, per evitare incongruenze nel database. Infatti, come già accennato, la tabella utenti presenta delle dipendenze dalla tabella
recensioni a causa della chiave esterna presente in quest'ultima. Eliminare un utente che abbia scritto delle recensioni causa una violazione di integrità 
referenziale. Sebbene l'opzione MySql ON DELETE CASCADE avrebbe potuto risolvere questo problema facilmente, è stato preferito, a scopo didattico, fare delle 
opportune verifiche sull'eventuale presenza di recensioni associate all'id utente da eliminare. In caso di esito positivo, avverrà prima la loro eliminazione, 
poi quella dell'utente associato. La gestione della tabella utenti prevede anche il pulsante di ban/unban per bloccare/sbloccare l'accesso al sito di un 
determinato utente. La tabella movie e music prevede la cancellazione dei singoli prodotti ma anche del loro inserimento. L'inserimento dei prodotti nel database
è facilitato da appositi campi di input di tipo text-area, ognuno dei quali rappresenta un'attributo del record da inserire nel database. Infine la tabella delle
recensioni permette la sola eliminazione del record indesiderato. 