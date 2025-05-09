<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['success' => false, 'message' => 'Utente non loggato.']);
    exit();
}

// Verifica se il metodo è POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodifica i dati JSON
    $input = json_decode(file_get_contents('php://input'), true);
    $id_user = $_SESSION['id_user'];
    $id_folder = $input['id_folder'] ?? null;

    if ($id_folder) {
        // Verifica che la cartella appartenga all'utente loggato
        $checkQuery = "SELECT id_folder FROM folders WHERE id_folder = ? AND id_user = ?";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->bind_param("ii", $id_folder, $id_user);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Cancella la cartella
            $query = "DELETE FROM folders WHERE id_folder = ? AND id_user = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $id_folder, $id_user);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cartella cancellata con successo.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore durante la cancellazione della cartella.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Non hai i permessi per cancellare questa cartella.']);
        }

        $stmtCheck->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'ID cartella non fornito.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida.']);
    exit();
}
?>