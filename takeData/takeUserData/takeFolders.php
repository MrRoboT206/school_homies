<?php
$stmtFolders = $conn->prepare("SELECT f.name, f.type FROM folders as f WHERE f.id_user = ?");
$stmtFolders->bind_param("i", $_SESSION['id_user']);
$stmtFolders->execute();
$resultFolders = $stmtFolders->get_result();  
?>