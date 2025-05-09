<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

header('Content-Type: application/json'); // Imposta il tipo di contenuto JSON

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['success' => false, 'message' => 'Utente non loggato.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['folder_name']));
    $type = htmlspecialchars(trim($_POST['type_folder']));
    $id_user = $_SESSION['id_user'];

    $query = "INSERT INTO folders (id_user, name, type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id_user, $name, $type);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cartella creata con successo!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante la creazione della cartella.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida.']);
    exit();
}
?>