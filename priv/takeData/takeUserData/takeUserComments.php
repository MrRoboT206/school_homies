<?php
$stmtComments = $conn->prepare("SELECT comments.id_comment, comments.text, posts.title as pTitle, posts.description FROM comments JOIN posts ON comments.id_post = posts.id_post WHERE comments.id_user = ?");
$stmtComments->bind_param("i", $id_user);
$stmtComments->execute();
$commentsResult = $stmtComments->get_result();
$stmtComments->close();
