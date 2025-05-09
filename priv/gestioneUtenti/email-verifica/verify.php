<?php
include "../../include/connessione.inc";

if (!isset($_GET['token'])) {
    die("Token mancante.");
}

$token = $_GET['token'];

// 1. Recupera il token dalla tabella
$stmt = $conn->prepare("SELECT id_user, expires_at FROM email_verifications WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $id_user = $row['id_user'];
    $expires = $row['expires_at'];

    if (strtotime($expires) < time()) {
        die("Token scaduto.");
    }

    $stmt->close(); // ✅ IMPORTANTE: chiudere prima di fare altre query

    // 2. Attiva l'utente
    $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();

    // 3. Rimuovi il token usato
    $stmt = $conn->prepare("DELETE FROM email_verifications WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();

    echo "✅ Verifica completata con successo.";
} else {
    echo "❌ Token non valido.";
}
?>