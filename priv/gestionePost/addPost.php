<?php
include "../include/connessione.inc";
session_start();

// Variabili per il post
$title = $_POST['title'];
$description = $_POST['description'];
$id_user = $_SESSION['id_user'];
$date_event = $_POST['date_event'] ?? null;
$type_post = $_POST['type_post'];
$image_path = null;

// Gestione caricamento immagine
if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['file_attachment'];

    // Controlla che il file non superi i 5MB
    if ($image['size'] > 5 * 1024 * 1024) {
        die("L'immagine supera la dimensione massima di 5MB.");
    }

    // Directory di upload
    $upload_dir = "../uploads/images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Crea la directory se non esiste
    }

    // Genera un nome unico per l'immagine
    $image_name = uniqid() . "_" . basename($image['name']);
    $target_file = $upload_dir . $image_name;

    // Sposta il file caricato nella directory di destinazione
    if (move_uploaded_file($image['tmp_name'], $target_file)) {
        $image_path = "uploads/images/" . $image_name; // Percorso relativo da salvare nel database
    } else {
        die("Errore durante il caricamento dell'immagine.");
    }
}else echo "ihofesof";

// Inserisci il post nel database
$stmt = $conn->prepare("INSERT INTO posts (title, description, id_user, date_event, image_path, type_post) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissi", $title, $description, $id_user, $date_event, $image_path, $type_post);
$stmt->execute();

header("Location: ../../pub/index.php");
?>