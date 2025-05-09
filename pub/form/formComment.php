<form action="../priv/gestionePost/addComment.php" method="post">
    <input type="hidden" name="id_post" value="<?php echo $postRow['id_post']; ?>">
    <label for="comment">Commento</label>
    <input type="text" name="comment" id="text" placeholder="Inserisci un commento">
    <button type="submit">Aggiungi Commento</button>
</form>