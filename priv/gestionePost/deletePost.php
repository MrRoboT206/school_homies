<?php
session_start();
include "..//include/connessione.inc"; // Assicurati di avere una connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_post = $_POST['id_post'];

// Cancella il post
$query = $conn->prepare("DELETE FROM posts WHERE id_post = ? AND id_user = ?");
$query->bind_param("ii", $id_post, $id_user);
$query->execute();

header('Location: ../profile.php');
exit();
?>