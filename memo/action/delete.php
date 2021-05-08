<?php

require('../../common/auth.php');
require('../../common/database.php');

if(!isLogin()) {
    header('Location: ../../login/');
}

$edit_id = $_POST['edit_id'];
$user_id = getLoginId();

$pdo = getDatabaseConnection();

$statement = $pdo->prepare('DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id');
$statement->bindParam(':edit_id', $edit_id);
$statement->bindParam(':user_id', $user_id);
$statement->execute();

unset($_SESSION['selected_memo']);

header('Location: ../../memo/');
exit;

?>