<?php include "../priv/include/start.inc"; ?>
<?php include "../priv/include/connessione.inc"; ?>
<?php session_start(); ?>

<style>
    /* Stile base e reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f7f9fa;
        color: #0f1419;
    }
    
    /* Layout principale */
    .layout-container {
        display: flex;
        min-height: 100vh;
        position: relative;
    }
    
    /* Sidebar migliorata */
    .sidebar {
        width: 280px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        padding: 15px 0;
        background-color: #fff;
        border-right: 1px solid #e1e8ed;
        overflow-y: auto;
        z-index: 200;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    /* Logo e immagine */
    .logo {
        display: flex;
        align-items: center;
        padding: 0 20px 20px 20px;
        margin-bottom: 15px;
        border-bottom: 1px solid #f0f3f5;
    }
    
    .logo i {
        font-size: 1.8rem;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 10px;
    }
    
    .logo img {
        height: 35px;
        width: auto;
        cursor: pointer;
    }
    
    /* Voci del menu */
    .menu-item {
        display: flex;
        align-items: center;
        padding: 14px 15px;
        margin: 5px 12px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f1419;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .menu-item:hover {
        background-color: #e8f5fe;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        transform: translateX(2px);
    }
    
    .menu-item i {
        margin-right: 15px;
        font-size: 1.3rem;
        width: 24px;
        text-align: center;
    }
    
    .active-menu {
        color: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        background-color: rgba(29, 104, 242, 0.1);
    }
    
    /* Pulsante di post */
    .post-button {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 14px 20px;
        font-size: 1.1rem;
        font-weight: bold;
        width: calc(100% - 24px);
        margin: 20px 12px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        box-shadow: 0 2px 5px rgba(106, 17, 203, 0.3);
    }
    
    .post-button:hover {
        opacity: 0.9;
    }
    
    /* Profilo utente */
    .user-profile {
        display: flex;
        align-items: center;
        padding: 12px;
        margin: 15px 12px;
        border-radius: 15px;
        background-color: #f7f9fa;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .user-profile:hover {
        background-color: #e8f5fe;
    }
    
    /* Area principale del contenuto */
    .main-content {
        flex: 1;
        margin-left: 280px;
        width: calc(100% - 280px);
    }
    
    /* Header migliorato */
    .header-section {
        background-color: rgba(255, 255, 255, 0.98);
        padding: 15px 25px;
        border-bottom: 1px solid #e1e8ed;
        position: fixed;
        top: 0;
        left: 280px;
        right: 0;
        z-index: 150;
        backdrop-filter: blur(5px);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        height: auto;
        display: flex;
        align-items: center;
    }
    
    .header-content {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-title {
        font-size: 1.6rem;
        font-weight: bold;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
    }
    
    .header-title i {
        margin-right: 10px;
    }
    
    .header-subtitle {
        color: #657786;
        font-size: 1rem;
    }
    
    /* Barra di ricerca */
    .search-container {
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 20px;
        border: 1px solid #e1e8ed;
        border-radius: 25px;
        font-size: 1rem;
        background-color: #f7f9fa;
        transition: all 0.2s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #6a11cb;
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba(106, 17, 203, 0.2);
    }
    
    /* Area dei post */
    .posts-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 120px 20px 20px 20px; /* Spazio extra per l'header fisso */
    }
    
    /* Area di benvenuto */
    .welcome-area {
        margin-bottom: 25px;
        padding: 15px 0;
        border-bottom: 1px solid #e1e8ed;
    }
    
    /* Pulsanti di login */
    .btn-twitter {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
        display: inline-block;
    }
    
    .btn-twitter-outline {
        background: transparent;
        color: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        padding: 9px 19px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #6a11cb;
        display: inline-block;
    }
    
    /* Messaggi di notifica o login */
    .message-box {
        padding: 25px;
        background: white;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        text-align: center;
    }

    /* Stile per i pulsanti con gradiente */
    button, .btn-twitter, .btn-twitter-outline {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    button:hover, .btn-twitter:hover, .btn-twitter-outline:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
</style>

<div class="layout-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-book"></i>
            <img onclick="hihihiha()" src="hihihiha/download.jpg" alt="School Homies Logo">
        </div>
        
        <a href="index.php" class="menu-item <?= !isset($_GET['type_post']) && !isset($_GET['search']) ? 'active-menu' : '' ?>">
            <i class="fas fa-home"></i> Home
        </a>
        
        <a href="index.php?type_post=1" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 1 ? 'active-menu' : '' ?>">
            <i class="fas fa-hashtag"></i> Post
        </a>

        <a href="index.php?type_post=3" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 3 ? 'active-menu' : '' ?>">
            <i class="fas fa-book-open"></i> Appunti
        </a>

        <a href="index.php?type_post=2" class="menu-item <?= isset($_GET['type_post']) && $_GET['type_post'] == 2 ? 'active-menu' : '' ?>">
            <i class="fas fa-calendar-alt"></i> Eventi
        </a>
        
        <?php if (isset($_SESSION['email'])): ?>
            <button type="button" class="post-button" data-toggle="modal" data-target="#postModal">
                <i class="fas fa-pen"></i> Crea nuovo post
            </button>
            
            <a href="./profile.php?id_user=<?= $_SESSION['id_user']?>" style="text-decoration: none; color: inherit;">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'].'+'.$_SESSION['surname']) ?>" 
                         style="width: 45px; height: 45px; border-radius: 50%; margin-right: 12px;">
                    <div>
                        <strong><?= htmlspecialchars($_SESSION['name']) ?> <?= htmlspecialchars($_SESSION['surname']) ?></strong>
                        <div style="color: #657786; font-size: 0.9rem;">@<?= htmlspecialchars(strtolower(str_replace(' ', '', $_SESSION['name']))) ?></div>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>
    
    <!-- Contenuto principale -->
    <div class="main-content">
        <!-- Header unificato con barra di ricerca -->
        <div class="header-section">
            <div class="header-content">
                <div>
                    <div class="header-title">
                        <i class="fa-solid fa-book"></i> School Homies
                    </div>
                    <div class="header-subtitle">Connettiti con i tuoi compagni di scuola</div>
                </div>
                
                <div class="search-container">
                    <form method="GET" action="index.php">
                        <input type="text" name="search" placeholder="Cerca nei post..." class="search-input">
                        <button type="submit" style="display: none;">Cerca</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contenitore dei post -->
        <div class="posts-container">
            <?php if (isset($_SESSION['email'])): ?>
                <div class="welcome-area">
                    <h2>Benvenuto <?= htmlspecialchars($_SESSION['name']) ?> <?= htmlspecialchars($_SESSION["surname"]) ?></h2>
                </div>
                
                <?php include 'form/formPost.php'; ?>
                
                <?php
                    if (isset($_GET['type_post'])) {
                        $type_post = intval($_GET['type_post']);
                        include '../priv/takeData/takePosts.php';
                        include './showData/showPosts.php';
                    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
                        include '../priv/takeData/searchPosts.php';
                        include './showData/showPosts.php';
                    } else {
                        include '../priv/takeData/takeposts.php';
                        include './showData/showPosts.php';
                    }
                ?>
                
            <?php else: ?>
                <div class="message-box">
                    <p>Devi effettuare il login per accedere a questa pagina.</p>
                    <div style="margin-top: 15px;">
                        <a href='login.php' class="btn-twitter">Login</a>
                        <a href='registrazione.php' class="btn-twitter-outline">Registrati</a>
                    </div>
                </div>
                <?php die(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function hihihiha() {
        alert("HIHIHIHA");
    }

    document.querySelectorAll('.add-to-folder-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const postId = this.getAttribute('data-post-id');

            fetch('../../priv/gestionePost/addToFolder.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    document.getElementById('folderPopup-' + postId).style.display = 'none';
                    this.reset();
                }
            })
            .catch(error => {
                console.error(error);
                alert('Si è verificato un errore durante l\'operazione.');
            });
        });
    });
</script>

<?php include "../priv/include/end.inc"; ?>