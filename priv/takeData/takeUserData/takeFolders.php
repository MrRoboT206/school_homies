<?php

if (!isset($id_user)) {
    $id_user = $_SESSION['id_user'] ?? null;
}

if (!$id_user) {
    die("Errore: ID utente non specificato.");
}

if (!function_exists('getUserFolders')) {
    function getUserFolders($conn, $id_user) {
        // Recupera tutte le cartelle dell'utente specificato (private e pubbliche)
        $stmt = $conn->prepare("
            SELECT f.id_folder, f.name, f.type 
            FROM folders AS f 
            WHERE f.id_user = ?
        ");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }
}

if (!function_exists('getPublicFolders')) {
    function getPublicFolders($conn, $id_user = null, $exclude_logged_user = true) {
        // Costruisce la query in base ai parametri
        $query = "SELECT f.id_folder, f.name, f.type, f.id_user FROM folders AS f WHERE f.type = 'public'";
        
        if ($exclude_logged_user) {
            $query .= " AND f.id_user != ?";
        } elseif ($id_user !== null) {
            $query .= " AND f.id_user = ?";
        }

        $stmt = $conn->prepare($query);

        if ($exclude_logged_user || $id_user !== null) {
            $stmt->bind_param("i", $id_user);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}

// Determina quale query eseguire in base al contesto
if ($_SESSION['id_user'] == $id_user) {
    // L'utente sta visualizzando il proprio profilo
    $resultFoldersUser = getUserFolders($conn, $_SESSION['id_user']);
} else {
    // L'utente sta visualizzando il profilo di qualcun altro
    $resultFoldersUser = getPublicFolders($conn, $id_user, false);
}
?>