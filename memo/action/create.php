<?php

require('../../common/auth.php');
require('../../common/database.php');

if(!isLogin()) {
    header('Location: ../../login/');
}

$user_id = getLoginId();
$pdo = getDatabaseConnection();

$title = '新規メモ';

$statement = $pdo->prepare('INSERT INTO memos (user_id, title, content) VALUES (:user_id, :title, null)');
$statement->bindParam(':user_id', $user_id);
$statement->bindParam(':title', $title);
$statement->execute();

$_SESSION['selected_memo'] = [
    'id' => $pdo->lastInsertId(),
    'title' => $title,
    'content' => '',
];

header('Location: ../../memo/');
exit;


?>