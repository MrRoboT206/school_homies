<?php
session_start();
include "..//include/connessione.inc"; // Assicurati di avere una connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_comment = $_POST['id_comment'];

// Cancella il commento
$query = $conn->prepare("DELETE FROM comments WHERE id_comment = ? AND id_user = ?");
$query->bind_param("ii", $id_comment, $id_user);
$query->execute();

header('Location: ../profile.php');
exit();
?>