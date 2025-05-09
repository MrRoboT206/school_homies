<?php
// Controlla se è stata effettuata una ricerca
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchQuery)) {
    // Connessione al database (modifica con i tuoi parametri)

    // Query per cercare nei campi title, description e nome utente
    $stmt = $conn->prepare("
        SELECT posts.*, users.name, users.surname 
        FROM posts 
        JOIN users ON posts.id_user = users.id_user
        WHERE posts.title LIKE ? 
           OR posts.description LIKE ? 
           OR CONCAT(users.name, ' ', users.surname) LIKE ?
    ");
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('sss', $likeQuery, $likeQuery, $likeQuery);
    $stmt->execute();
    $resultPosts = $stmt->get_result();
}
?>