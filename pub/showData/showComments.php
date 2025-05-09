<?php
if ($resultComments->num_rows > 0) {
    echo "<ul>";
    while ($commentRow = $resultComments->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($commentRow['text']) . " - " . htmlspecialchars($commentRow['name']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "Nessun commento presente.";
}
?>