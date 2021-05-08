<?php

require('../../common/auth.php');
require('../../common/database.php');

if(!isLogin()) {
    header('Location: ../../login/');
}

$id = $_GET['id'];
$user_id = getLoginId();

$pdo = getDatabaseConnection();
$statement = $pdo->prepare('SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id');
$statement->bindParam(':id', $id);
$statement->bindParam(':user_id', $user_id);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);

$_SESSION['selected_memo'] = [ 
    'id' => $result['id'],
    'title' => $result['title'],
    'content' => $result['content'],
];

header('Location: ../../memo/');
exit;

?>