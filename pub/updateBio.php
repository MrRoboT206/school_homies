<?php
session_start();
include "../priv/include/connessione.inc"; // Assicurati di avere una connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$bio = $_POST['bio'];

// Aggiorna la biografia dell'utente
$query = $conn->prepare("UPDATE users SET bio = ? WHERE id_user = ?");
$query->bind_param("si", $bio, $id_user);
$query->execute();

header('Location: profile.php');
exit();
?>