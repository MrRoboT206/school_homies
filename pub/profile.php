<?php
session_start();
include "../priv/include/connessione.inc";

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_GET['id_user'] ?? $_SESSION['id_user']; // Ottieni l'ID dell'utente da visualizzare
include "../priv/takeData/takeUserData/takeUserInfo.php"; // Recupera le informazioni dell'utente
include "../priv/takeData/takeUserData/takeUserComments.php";
include "../priv/takeData/takeUserData/takeFolders.php";
include "../priv/takeData/takeUserData/takeUserPosts.php";
?>
<?php include "../priv/include/start.inc"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, rgb(134, 47, 216), rgb(13, 159, 216)) fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        .main-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
            position: relative;
            left: 0;
            right: 0;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .profile-header {
            margin-bottom: 30px;
        }
        
        .profile-header h1 {
            color: #333;
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .profile-email {
            color: #666;
            font-size: 1.2rem;
            font-weight: 500;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            display: inline-block;
        }
        
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); /* Gradiente rosso */
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .logout-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            z-index: 100;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .home-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .section {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-left: auto;
            margin-right: auto;
        }
        
        .section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .section h2 {
            color: #444;
            margin-bottom: 25px;
            font-size: 1.8rem;
            border-bottom: 3px solid #f0f0f0;
            padding-bottom: 15px;
            display: inline-block;
            font-weight: 700;
        }
        
        .bio-content {
            margin: 25px auto;
            line-height: 1.7;
            color: #555;
            text-align: center;
            max-width: 700px;
            font-size: 1.1rem;
        }
        
        .btn {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
            margin: 15px 8px;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        
        .btn-danger:hover {
            opacity: 0.9;
        }
        
        .post, .comment {
            border: 1px solid #e0e0e0;
            padding: 25px;
            margin: 20px auto;
            border-radius: 15px;
            background-color: #f9f9f9;
            max-width: 750px;
            text-align: left;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .post:hover, .comment:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .folder-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            width: 100%;
        }
        
        .folder-item {
            background-color: #f0f7ff;
            border: 1px solid #d0e3ff;
            padding: 20px;
            border-radius: 15px;
            width: calc(33.33% - 20px);
            min-width: 220px;
            text-align: center;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .folder-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #e4f1ff;
        }
        
        .folder-item a {
            text-decoration: none;
            color: #3498db;
            font-weight: 600;
            font-size: 1.1rem;
            transition: color 0.3s;
            display: block;
            margin-bottom: 10px;
        }
        
        .folder-item a:hover {
            color: #2176ff;
        }
        
        .folder-item .btn {
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 0.95rem;
        }
        
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            z-index: 1000;
            width: 90%;
            max-width: 550px;
            text-align: center;
        }
        
        .popup h3 {
            color: #444;
            margin-bottom: 25px;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            backdrop-filter: blur(5px);
        }
        
        textarea, input[type="text"], select {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        textarea:focus, input[type="text"]:focus, select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn-group {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .no-content {
            color: #777;
            font-style: italic;
            margin: 30px 0;
            font-size: 1.1rem;
        }
        
        ul {
            list-style: none;
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            padding: 0;
        }
        
        li {
            background-color: #f0f7ff;
            border: 1px solid #d0e3ff;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        li:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        #message {
            margin-top: 20px;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
        }
        
        .message-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .folder-type {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 8px 0;
        }
        
        .type-private {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }
        
        .type-public {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .folder-item {
                width: calc(50% - 20px);
            }
            
            .profile-card, .section {
                padding: 30px 20px;
                width: 100%;
            }
            
            .profile-header h1 {
                font-size: 2rem;
            }
            
            body {
                padding: 20px 10px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .main-container {
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .folder-item {
                width: 100%;
            }
            
            .btn {
                padding: 12px 20px;
                font-size: 1rem;
            }
            
            .home-btn, .logout-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }
        
        /* Specifica supporto per schermi più grandi */
        @media (min-width: 1200px) {
            .main-container {
                margin: 0 auto;
            }
            
            body {
                justify-content: center;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="home-btn">🏠 Home</a>
    
    <div class="main-container" style="width: 100%; max-width: 900px; margin: 0 auto;">
        <!-- Riquadro profilo -->
        <div class="profile-card">
            <a href='../priv/gestioneUtenti/logout.php' class="logout-btn">Logout</a>
            <div class="profile-header">
                <h1>Profilo di <?php echo htmlspecialchars($userInfoResult['name'] ?? $userInfoResult['email']); ?></h1>
                <div class="profile-email"><?php echo htmlspecialchars($userInfoResult['email']); ?></div>
            </div>
            
            <div class="bio-content">
                <h2>Biografia</h2>
                <p><?php echo nl2br(htmlspecialchars($userInfoResult['bio'] ?? 'Nessuna biografia inserita')); ?></p>
                <?php if($_SESSION['id_user'] == $id_user): ?>
                    <button class="btn" onclick="openPopup()">Aggiorna Biografia</button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sezione cartelle -->
        <div class="section">
            <h2>Le cartelle di <?= htmlspecialchars($userInfoResult['name'])?></h2>
            
            <?php if($_SESSION['id_user'] == $id_user): ?>
                <button class="btn" onclick="openFolderPopup()">Crea Cartella</button>
            <?php endif; ?>
            
            <?php if ($resultFoldersUser->num_rows > 0): ?>
                <div class="folder-list">
                    <?php while ($folder = $resultFoldersUser->fetch_assoc()): ?>
                        <div class="folder-item">
                            <a href="../priv/gestionePost/viewFolder.php?folder_name=<?php echo urlencode($folder['name']); ?>&id_user=<?php echo $id_user; ?>">
                                <strong><?php echo htmlspecialchars($folder['name']); ?></strong>
                            </a>
                            
                            <div class="folder-type <?php echo $folder['type'] === 'private' ? 'type-private' : 'type-public'; ?>">
                                <?php echo $folder['type'] === 'private' ? 'Privata' : 'Pubblica'; ?>
                            </div>

                            <?php if ($_SESSION['id_user'] == $id_user): ?>
                                <button class="btn btn-danger" onclick="deleteFolder(<?php echo $folder['id_folder']; ?>)">Elimina</button>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-content">Non hai ancora creato nessuna cartella.</p>
            <?php endif; ?>
        </div>

        <!-- Sezione post -->
        <div class="section">
            <h2>I post di <?= htmlspecialchars($userInfoResult['name'])?></h2>
            <?php include "./showData/showPosts.php"; ?>
        </div>

        <!-- Sezione commenti -->
        <div class="section">
            <h2>I commenti di <?= htmlspecialchars($userInfoResult['name'])?></h2>
            <?php if ($commentsResult->num_rows > 0): ?>
                <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                    <div class="comment">
                        <form method="post" action="../priv/gestionePost/deleteComment.php">
                            <small>Post associato: </small>
                            <div class="post">
                                <strong><?php echo htmlspecialchars($comment['pTitle']); ?></strong><br>
                                <?php echo htmlspecialchars($comment['description']); ?>
                            </div>
                            <p>Commento: <?php echo htmlspecialchars($comment['text']); ?></p>
                            <input type="hidden" name="id_comment" value="<?php echo $comment['id_comment']; ?>">
                            <?php if($_SESSION['id_user'] == $id_user): ?>
                                <button type="submit" class="btn btn-danger">Cancella Commento</button>
                            <?php endif; ?>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-content">Non hai ancora pubblicato commenti.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pop-up biografia -->
    <div class="popup-overlay" id="popup-overlay"></div>
    <div class="popup" id="popup">
        <h3>Aggiorna Biografia</h3>
        <form method="post" action="updateBio.php">
            <textarea name="bio" placeholder="Scrivi qualcosa su di te..."><?php echo htmlspecialchars($userInfoResult['bio'] ?? ''); ?></textarea>
            <div class="btn-group">
                <button type="submit" class="btn">Salva</button>
                <button type="button" class="btn" onclick="closePopup()" style="background-color: #95a5a6;">Chiudi</button>
            </div>
        </form>
    </div>

    <!-- Pop-up cartella -->
    <div class="popup-overlay" id="folder-popup-overlay"></div>
    <div class="popup" id="folder-popup">
        <h3>Crea Nuova Cartella</h3>
        <form id="addFolderForm">
            <input type="text" name="folder_name" id="folder_name" placeholder="Nome della cartella" required>
            <select name="type_folder" id="type_folder">
                <option value="private">Privata</option>
                <option value="public">Pubblica</option>
            </select>
            <div class="btn-group">
                <button type="submit" class="btn">Crea</button>
                <button type="button" class="btn" onclick="closeFolderPopup()" style="background-color: #95a5a6;">Chiudi</button>
            </div>
        </form>
        <div id="message"></div>
    </div>

    <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popup-overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        }

        function openFolderPopup() {
            document.getElementById('folder-popup').style.display = 'block';
            document.getElementById('folder-popup-overlay').style.display = 'block';
        }

        function closeFolderPopup() {
            document.getElementById('folder-popup').style.display = 'none';
            document.getElementById('folder-popup-overlay').style.display = 'none';
            document.getElementById('message').textContent = '';
            document.getElementById('message').className = '';
        }

        // Gestione del form con AJAX
        document.getElementById('addFolderForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('../priv/gestionePost/addFolder.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message-success';
                    setTimeout(() => {
                        closeFolderPopup();
                        location.reload();
                    }, 1500);
                } else {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message-error';
                }
            })
            .catch(error => {
                console.error('Errore:', error);
            });
        });

        function deleteFolder(idFolder) {
            if (confirm("Sei sicuro di voler eliminare questa cartella?")) {
                fetch('../priv/gestionePost/deleteFolder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_folder: idFolder })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                });
            }
        }
    </script>
<?php include "../priv/include/end.inc"; ?>
</body>
</html>