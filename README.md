# E-Commerce PHP
In questo progetto mi sono divertito a scrivere codice in PHP dando vita ad un sito ispirato ad un e-commerce. E' stato molto utile per ripassare ed approfondire il concetto di programmazione ad oggetti sfruttandone metodi e proprietà per implementare diverse CRUD nel sito ed alcune Validazioni (registrazione, accesso, modifica e creazione prodotti...). Nel sito ho implementato una sezione Admin da dove è possibile gestire i propri prodotti in vendita, controllare gli ordini ricevuti e creare dei propri codici promozionali per permettere degli sconti agli utenti. Un utente "Customer" può invece aggiungere i prodotti al carrello visualizzarlo con possibilità di usufruire di un codice sconto o modificarne le quantità dei prodotti per poi procedere all'acquisto (l'acquisto è una simulazione senza procedura di pagamento), può modificare i propri dati di accesso e di fatturazione, può visualizzare gli ordini effettuati. Inoltre è possibile usufruire delle funzionalità di shopping con carrello ed acquisto anche senza registrazione.

## Installazione
1. Copiare la cartella "e-commerce" nella root del webserver: nel caso si usa MAMP mettere la cartella nel percorso: "C:\MAMP\htdocs"
2. Modificare il file "php/config.php" impostando i valori per le costanti di connessione al database.
3. In phpmyadmin creare un nuovo database, quindi aprire il file "db.sql", copiare il contenuto del file ed eseguire i comandi. La struttura di base del database sarà così inserita.

Una volta effettuate le procedure aprire http://localhost/e-commerce e il sito funzionerà.

Saranno inseriti due utenti di partenza:
1. User: admin@gmail.com Password: password
2. User: customer@gmail.com Password: password

Inizialmente non ci saranno prodotti nello Shop, cliccare su Coming soon nella sezione Products per aggiungerli.


