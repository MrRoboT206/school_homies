<?php
include "../include/connessione.inc";
$stmt = $conn->prepare("INSERT INTO partecipantsEvents (id_partecipant, id_event) VALUES (?, ?)");
$stmt->bind_param("ii", $_POST['id_partecipant'], $_POST['id_event']);
$stmt->execute();

?>