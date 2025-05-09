<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

// Recupera l'ID del post dalla query string
$id_post = $_GET['id_post'] ?? null;

if (!$id_post) {
    echo "Post non specificato.";
    exit();
}

// Recupera i dettagli del post
$query = "SELECT p.title, p.description, p.date, p.image_path, u.name AS author, u.id_user 
          FROM posts p
          INNER JOIN users u ON p.id_user = u.id_user
          WHERE p.id_post = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_post);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post non trovato.";
    exit();
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per le icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container py-4">
    <div class="post-card">
        <div class="post-header d-flex justify-content-between align-items-center">
            <a href="../../pub/profile.php?id_user=<?= $post['id_user']; ?>" class="text-decoration-none">
                <div class="user-info">
                    <strong><?= htmlspecialchars($post['author']); ?></strong>
                </div>
            </a>
            <span class="post-time text-muted"><?= htmlspecialchars($post['date']); ?></span>
        </div>

        <div class="post-body mt-3">
            <h5 class="mb-2"><strong><?= htmlspecialchars($post['title']); ?></strong></h5>
            <p class="post-text"><?= nl2br(htmlspecialchars($post['description'])); ?></p>
            <?php if (!empty($post['image_path'])): ?>
                <div class="post-image mt-3">
                    <img src="<?= htmlspecialchars($post['image_path']); ?>" alt="Immagine del post" class="img-fluid rounded">
                </div>
            <?php endif; ?>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-primary mt-3">Torna indietro</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>