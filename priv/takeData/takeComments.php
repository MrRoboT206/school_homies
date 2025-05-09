<?php
$stmtComments = $conn->prepare("SELECT c.text, u.name FROM comments as c, users as u WHERE id_post = $postRow[id_post] AND c.id_user = u.id_user");
$stmtComments->execute();
$resultComments = $stmtComments->get_result();  
?>