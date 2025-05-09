<?php
$stmtUserInfo = $conn->prepare("SELECT email, bio, name FROM users WHERE id_user = ?");
$stmtUserInfo->bind_param("i", $id_user);
$stmtUserInfo->execute();
$userInfoResult = $stmtUserInfo->get_result();
$userInfoResult = $userInfoResult->fetch_assoc();
$stmtUserInfo->close();
