<?php
if (!isset($resultFolders) || !$resultFolders instanceof mysqli_result) {
    echo "Errore: Nessuna cartella disponibile.";
    return;
}

// Ripristina il puntatore dei risultati di $resultFolders
mysqli_data_seek($resultFolders, 0);
?>
<button id="openPopup-<?php echo $postRow['id_post']; ?>">Aggiungi alla cartella</button>

<div id="folderPopup-<?php echo $postRow['id_post']; ?>">
    <form action="../../priv/gestionePost/addToFolder.php" method="POST">
        <input type="hidden" name="id_post" value="<?php echo $postRow['id_post']; ?>">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        <label for="folder">Seleziona una cartella:</label>
        <?php
        if ($resultFolders->num_rows > 0) {
            echo "<select name='folder' id='folder'>";
            while ($folderRow = $resultFolders->fetch_assoc()) {
                $folderName = htmlspecialchars($folderRow['name']);
                $folderType = htmlspecialchars($folderRow['type']);
                echo "<option value='" . $folderRow['id_folder'] . "'>" . $folderName . " (" . $folderType . ")</option>";
            }
            echo "</select>";
        } else {
            echo "Nessuna cartella presente.";
        }
        ?>
        <button type="submit">Aggiungi</button>
    </form>
</div>

<script>
document.getElementById('openPopup-<?php echo $postRow['id_post']; ?>').addEventListener('click', function() {
    document.getElementById('folderPopup-<?php echo $postRow['id_post']; ?>').style.display = 'block';
});
</script>