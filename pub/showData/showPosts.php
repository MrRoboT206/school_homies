<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Feed</title>
    <!-- Bootstrap CSS -->
    <link href="path/to/local/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per le icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --orange: rgb(121, 29, 242);
            --twitter-dark: #15202b;
            --twitter-light-gray: #e1e8ed;
            --twitter-text-gray: #657786;
        }
        
        body {
            background-color: #f7f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        
        .post-card {
            background: #ffffff;
            border: none; /* Rimuovi il bordo */
            border-radius: 16px; /* Bordi arrotondati */
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombra leggera */
        }
        
        .post-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        
        .post-header {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0; /* Separatore */
        }
        
        .post-body {
            padding: 16px;
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
        }
        
        .post-actions {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0; /* Separatore */
            background-color: #f9f9f9; /* Sfondo leggero */
        }
        
        .btn-twitter {
            background: var(--twitter-blue);
            color: white;
            border-radius: 20px;
            padding: 4px 16px;
            font-weight: bold;
            border: none;
        }
        
        .btn-twitter:hover {
            background: rgb(242, 150, 29);
            color: white;
        }
        
        .btn-twitter-outline {
            background: transparent;
            color: var(--twitter-blue);
            border-radius: 20px;
            padding: 4px 16px;
            border: 1px solid var(--twitter-blue);
            font-weight: bold;
        }
        
        .btn-twitter-outline:hover {
            background: rgba(29, 161, 242, 0.1);
        }
        
        .participant-badge {
            background: var(--twitter-light-gray);
            border-radius: 12px;
            padding: 4px 8px;
            margin: 2px;
            display: inline-block;
            font-size: 0.8rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            border: 2px solid #1da1f2; /* Aggiungi un bordo colorato */
        }
        
        .username {
            font-size: 0.9rem;
            color: #657786;
        }
        
        .post-time {
            font-size: 0.8rem;
            color: #aab8c2;
        }
        
        .action-btn {
            color: #657786;
            background: none;
            border: none;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .action-btn:hover {
            background-color: rgba(29, 161, 242, 0.1);
            color: #1da1f2;
        }
        
        .comment-form {
            padding: 12px 16px;
            border-top: 1px solid var(--twitter-light-gray);
            display: none;
        }
        
        .event-details {
            background-color: rgba(29, 161, 242, 0.05);
            border-radius: 12px;
            padding: 12px;
            margin-top: 12px;
            font-size: 0.9rem;
            color: #555;
        }
        
        .file-attachment a {
            color: #1da1f2;
            text-decoration: none;
            font-weight: bold;
        }
        
        .file-attachment a:hover {
            text-decoration: underline;
        }
        
        .no-posts {
            text-align: center;
            padding: 40px 20px;
            color: var(--twitter-text-gray);
        }
        
        .post-text {
            font-size: 1.1rem;
            line-height: 1.5;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
<div class="container py-4">

        <?php
        include '../priv/takeData/takeUserData/takeFolders.php';

        // Recupera le cartelle dell'utente loggato
        $resultFolders = getUserFolders($conn, $_SESSION['id_user']);

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            echo '<div class="alert alert-' . ($message['status'] === 'success' ? 'success' : 'danger') . '">';
            echo htmlspecialchars($message['text']);
            echo '</div>';
        }
        ?>

        <?php if ($resultPosts->num_rows > 0): ?>
            <?php while ($postRow = $resultPosts->fetch_assoc()): ?>
                <div class="post-card">
                    <div class="post-header">
                        <!-- permette di cliccare il  noe e andare alla pagina dell utenete -->
                        <a href="profile.php?id_user=<?= $postRow['id_user'] ?>">
                            <div class="user-info">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($postRow['name']) ?>&background=random" class="user-avatar">
                                <div>
                                    <strong><?= htmlspecialchars($postRow['name']) ?></strong>
                                    <div class="username">@<?= strtolower(str_replace(' ', '', htmlspecialchars($postRow['name']))) ?></div>
                                </div>
                            </div>
                        </a>
                        <span class="post-time"><?= htmlspecialchars($postRow['date']) ?></span>
                    </div>

                    <div class="post-body">
                        <h5 class="mb-2"><strong><?= htmlspecialchars($postRow['title']) ?></strong></h5>
                        <p class="post-text"><?= htmlspecialchars($postRow['description']) ?></p>

                        <?php if ($postRow['type_post'] == 3): ?>
                            <div class="event-details">
                                <i class="fas fa-info-circle"></i> 
                                <?php //prendi l'img della dir
                                $img = $postRow['image_path'] ? $postRow['image_path'] : '../priv/uploads/images/default.png'; 
                                echo '<img src="../priv/' . htmlspecialchars($img) . '" alt="Immagine post" class="img-fluid" style="max-width: 100%; height: auto;">';
                                ?>
                            </div>
                            <?php if (!empty($postRow['file_path'])): ?>
                                <div class="file-attachment mt-3">
                                    <i class="fas fa-paperclip"></i> 
                                    <a href="<?= htmlspecialchars($postRow['file_path']) ?>" target="_blank" download>
                                        Scarica allegato
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($postRow['type_post'] == 2): ?>
                            <div class="event-details">
                                <i class="fas fa-calendar-alt"></i> 
                                <strong>Data evento:</strong> <?= htmlspecialchars($postRow['date_event']) ?>
                            </div>

                            <!-- Form per partecipare all'evento -->
                            <form class="partecipateForm mt-3" method="POST" action="../../priv/gestionePost/addPartecipantEvent.php">
                                <input type="hidden" name="id_event" value="<?= $postRow['id_post'] ?>">
                                <button type="submit" class="btn btn-twitter">Partecipa</button>
                            </form>

                            <!-- Mostra i partecipanti -->
                            <div class="mt-3">
                                <h6>Partecipanti:</h6>
                                <?php
                                include '../priv/takeData/takePartecipants.php';
                                if ($partecipantResult->num_rows > 0) {
                                    while ($participant = $partecipantResult->fetch_assoc()) {
                                        echo '<span class="participant-badge">' . htmlspecialchars($participant['name']) . ' ' . htmlspecialchars($participant['surname']) . '</span>';
                                    }
                                } else {
                                    echo '<p class="text-muted">Nessun partecipante al momento.</p>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="post-actions">
                        <button class="action-btn toggle-comment" data-post-id="<?= $postRow['id_post'] ?>">
                            <i class="far fa-comment"></i>
                        </button>
                        <button class="action-btn">
                            <i class="far fa-heart"></i>
                        </button>
                        <?php include "./form/formAddToFolder.php"; ?>
                    </div>
                    <div class="comment-form" id="comment-form-<?= $postRow['id_post'] ?>">
                        <?php include "./form/formComment.php"; ?>
                    </div>
                    
                    <div class="px-3 pb-2">
                        <?php 
                        include "../priv/takeData/takeComments.php";
                        include "./showData/showComments.php"; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-posts">
                <i class="far fa-newspaper fa-3x mb-3"></i>
                <h4>Nessun post presente</h4>
                <p>Sii il primo a creare un post!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modale di successo -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle"></i> Successo</h5>
                    <!-- Aggiungi data-bs-dismiss="modal" per chiudere il modale -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <p>🎉 Partecipazione registrata con successo!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-twitter" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Includi jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Includi Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Gestione partecipazione evento
        $(document).on("submit", ".partecipateForm", function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                url: "../../priv/gestionePost/addPartecipantEvent.php",
                method: "POST",
                data: formData,
                success: function(response) {
                    $('#successModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert("Si è verificato un e l'operazone.");
                }
            });
        });
        
        // Mostra/nascondi form commenti
        $(".toggle-comment").click(function() {
            var postId = $(this).data('post-id');
            $("#comment-form-" + postId).slideToggle();
        });
        
        // Chiudi la modale e ricarica la pagina
        $('#successModal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    </script>
</body>
</html>