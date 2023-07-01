<?php
/* per collegarsi al db EMAIL RICEVUTI servono questi dati : */

$host = "localhost";
$userdb = "LOUIS FERNAND DJEMBOU";
$pswdb = "0apgF-pZ_OY2RJnW";
$nomedb = "email ricevuti";

/* collegamento */
$conn = new mysqli($host, $userdb, $pswdb, $nomedb);

if ($conn->connect_error):

    die(" Connessione Fallita: " . $conn->connect_error);

endif;

$sql = "CREATE TABLE IF NOT EXISTS emails (
    id INT(4) AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(255) NOT NULL,
    COGNOME VARCHAR(255) NOT NULL,
    EMAIL VARCHAR(255) NOT NULL,
    OGGETTO VARCHAR(255) NOT NULL,
    TESTO TEXT(5000) NOT NULL,
    DATA_INSERIMENTO TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DATA_AGGIORNAMENTO TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn -> query($sql) === TRUE) {
    # code...
    echo "TABELLA CREATA" . "<br>"
        . "<br>";
} else {
    # code...
    echo "TABELLA NON CREATA" . "<br>"
        . "<br>";
}

// PREVIENE INJECTION CIOE ATTACCHI DI HAKERS SI FA LO STATEMENT $stmt
$stmt = $conn->prepare("INSERT INTO emails ( NOME, COGNOME, EMAIL, OGGETTO, TESTO ) VALUES ( ?, ?, ?, ?, ? )");

$stmt->bind_param("sssss", $nome, $cognome, $email, $oggetto, $testo);

/*DATI CLIENTE ED IL SUO MESSAGGIO*/
$nome = $_POST['nome'];
$cognome = $_POST['Ccognome'];
$email = $_POST['email'];
$oggetto = $_POST['oggetto'];
$testo = $_POST['messaggio'];

$stmt -> execute();

if ( $conn -> query($sql) === TRUE ) {
    # code...
    echo "DATI INNSERITI CORRETTAMENTE"."<br>"
    ."<br>"
    ."<br>";
    echo '<a class="btn btn-primary" href="./menu.html"> GRAZIE,
    ORDINE EFFETTUATO CON SUCCESSO.<br><br><br> TORNA AL NOSTRO MENU ! </a>';
}else {
    # code...
    echo "DATI NON INSERITI" . $conn -> error;
}

/* chiusura dello $stmt INJECTION */
$stmt -> close();

/* chiusura collegamento al db EMAIL RICEVUTI */
$conn -> close();

?>