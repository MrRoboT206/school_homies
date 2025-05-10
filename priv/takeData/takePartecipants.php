<?php
    $stmtPartecipant = $conn->prepare("SELECT u.name, u.surname FROM users as u, partecipantsevents as pu WHERE pu.id_event = ? AND pu.id_partecipant = u.id_user");
    $stmtPartecipant->bind_param("i", $postRow['id_post']);
    $stmtPartecipant->execute();
    $partecipantResult = $stmtPartecipant->get_result();
    $stmtPartecipant->close();
?>