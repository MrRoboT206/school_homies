<?php
session_start();
include "../include/connessione.inc";

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    die("Errore: Utente non loggato.");
}

// Recupera i dati dal form
$id_user = $_SESSION['id_user'];
$id_event = isset($_POST['id_event']) ? intval($_POST['id_event']) : null;

if (!$id_event) {
    die("Errore: ID evento mancante.");
}

// Controlla se l'utente è già un partecipante all'evento
$checkStmt = $conn->prepare("SELECT * FROM partecipantsevents WHERE id_partecipant = ? AND id_event = ?");
$checkStmt->bind_param("ii", $id_user, $id_event);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("Errore: Sei già un partecipante a questo evento.");
}

// Inserisci il partecipante nella tabella
$stmt = $conn->prepare("INSERT INTO partecipantsevents (id_partecipant, id_event) VALUES (?, ?)");
$stmt->bind_param("ii", $id_user, $id_event);

if ($stmt->execute()) {
    echo "Partecipazione registrata con successo!";
} else {
    echo "Errore durante la registrazione della partecipazione.";
}

$stmt->close();
$conn->close();
?>