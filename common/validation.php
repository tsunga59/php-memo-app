<?php

// 空チェック
function emptyCheck(&$errors, $check_value, $message) {
    if(empty(trim($check_value))) {
        array_push($errors, $message);
    }
}

// 文字数チェック
function stringMinCheck(&$errors, $check_value, $message, $min_size=8) {
    if(mb_strlen($check_value) < $min_size) {
        array_push($errors, $message);
    }
}
function stringMaxCheck(&$errors, $check_value, $message, $max_size=255) {
    if(mb_strlen($check_value) > $max_size) {
        array_push($errors, $message);
    }
}

// メールアドレスチェック
function emailCheck(&$errors, $check_value, $message) {
    if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $check_value)) {
        array_push($errors, $message);
    }
}

// 半角英数字チェック
function stringTypeCheck(&$errors, $check_value, $message) {
    if(!preg_match("/^[a-zA-Z0-9]+$/", $check_value)) {
        array_push($errors, $message);
    }
}

// メールアドレス重複
function emailDuplicateCheck(&$errors, $check_value, $message) {
    $pdo = getDatabaseConnection();
    $statement = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $statement->bindParam(':email', $check_value);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if($result) {
        array_push($errors, $message);
    }
}