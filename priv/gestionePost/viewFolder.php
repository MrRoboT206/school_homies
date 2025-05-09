<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_GET['id_user'];
$folder_name = $_GET['folder_name'] ?? '';

if (empty($folder_name)) {
    echo "Cartella non specificata.";
    exit();
}

// Recupera l'ID della cartella
$query = "SELECT id_folder, type FROM folders WHERE id_user = ? AND name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $id_user, $folder_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Cartella non trovata.";
    exit();
}

$folder = $result->fetch_assoc();
$id_folder = $folder['id_folder'];
$folder_type = $folder['type'] ?? 'public';

// Recupera gli appunti associati alla cartella
$query = "SELECT p.id_post, p.title, p.description 
          FROM posts p
          INNER JOIN foldersnotes fn ON p.id_post = fn.id_post
          WHERE fn.id_folder = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_folder);
$stmt->execute();
$result = $stmt->get_result();

// Recupera il nome dell'utente proprietario della cartella
$query_user = "SELECT name, email FROM users WHERE id_user = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $id_user);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user_info = $user_result->fetch_assoc();
$user_name = $user_info['name'] ?? $user_info['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appunti in <?php echo htmlspecialchars($folder_name); ?></title>
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
        
        .folder-card {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-left: auto;
            margin-right: auto;
        }
        
        .folder-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .folder-header {
            margin-bottom: 30px;
        }
        
        .folder-header h1 {
            color: #333;
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .folder-owner {
            color: #666;
            font-size: 1.2rem;
            font-weight: 500;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            display: inline-block;
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #3498db;
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
        
        .back-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .folder-type-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 15px 0;
        }
        
        .folder-private {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }
        
        .folder-public {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        
        .notes-section {
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
        
        .notes-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .notes-section h2 {
            color: #444;
            margin-bottom: 25px;
            font-size: 1.8rem;
            border-bottom: 3px solid #f0f0f0;
            padding-bottom: 15px;
            display: inline-block;
            font-weight: 700;
        }
        
        .note-list {
            list-style: none;
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            padding: 0;
        }
        
        .note-item {
            background-color: #f0f7ff;
            border: 1px solid #d0e3ff;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
        }
        
        .note-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #e4f1ff;
        }
        
        .note-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .note-description {
            color: #555;
            line-height: 1.6;
            margin-top: 10px;
            font-size: 1.05rem;
        }
        
        .view-link {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        
        .view-link:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        }
        
        .no-notes {
            color: #777;
            font-style: italic;
            margin: 30px 0;
            font-size: 1.1rem;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .folder-card, .notes-section {
                padding: 30px 20px;
                width: 100%;
            }
            
            .folder-header h1 {
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
            .view-link {
                display: block;
                margin: 15px auto 5px;
                text-align: center;
                max-width: 200px;
            }
            
            .back-btn {
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
    <a href="../../pub/profile.php?id_user=<?php echo $id_user; ?>" class="back-btn">⬅️ Torna al profilo</a>
    
    <div class="main-container" style="width: 100%; max-width: 900px; margin: 0 auto;">
        <!-- Intestazione della cartella -->
        <div class="folder-card">
            <div class="folder-header">
                <h1>Cartella "<?php echo htmlspecialchars($folder_name); ?>"</h1>
                <div class="folder-owner">di <?php echo htmlspecialchars($user_name); ?></div>
            </div>
            
            <div class="folder-type-badge folder-<?php echo $folder_type; ?>">
                <?php echo $folder_type === 'private' ? 'Cartella Privata' : 'Cartella Pubblica'; ?>
            </div>
        </div>

        <!-- Sezione appunti -->
        <div class="notes-section">
            <h2>Appunti</h2>
            
            <?php if ($result->num_rows > 0): ?>
                <ul class="note-list">
                    <?php while ($note = $result->fetch_assoc()): ?>
                        <li class="note-item">
                            <div class="note-title"><?php echo htmlspecialchars($note['title']); ?></div>
                            <div class="note-description"><?php echo nl2br(htmlspecialchars($note['description'])); ?></div>
                            <a href="viewPost.php?id_post=<?php echo $note['id_post']; ?>" class="view-link">
                                Visualizza post completo
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="no-notes">Non ci sono appunti in questa cartella.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php 
    $stmt->close();
    $stmt_user->close();
    ?>
</body>
</html>