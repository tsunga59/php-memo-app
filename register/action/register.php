<?php

session_start();

require('../../common/validation.php');
require('../../common/database.php');

if(!empty($_POST)) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // バリデーション
    $_SESSION['errors'] = [];

    // 空チェック
    emptyCheck($_SESSION['errors'], $name, 'ユーザー名を入力してください。');
    emptyCheck($_SESSION['errors'], $email, 'メールアドレスを入力してください。');
    emptyCheck($_SESSION['errors'], $password, 'パスワードを入力してください。');

    // 文字数
    stringMaxCheck($_SESSION['errors'], $name, 'ユーザー名は255文字以内で入力しください。');
    stringMaxCheck($_SESSION['errors'], $email, 'メールアドレスは255文字以内で入力しください。');
    stringMaxCheck($_SESSION['errors'], $password, 'パスワードは255文字以内で入力しください。');
    stringMinCheck($_SESSION['errors'], $password, 'パスワードは8文字以上で入力してください。');

    if(!$_SESSION['errors']) {
        // メールアドレスチェック
        emailCheck($_SESSION['errors'], $email, '正しいメールアドレスを入力してください。');
    
        // 半角英数字チェック
        stringTypeCheck($_SESSION['errors'], $name, 'ユーザー名は半角英数字で入力してください。');
        stringTypeCheck($_SESSION['errors'], $password, 'パスワードは半角英数字で入力してください。');
    
        // メールアドレス重複チェック
        emailDuplicateCheck($_SESSION['errors'], $email, '指定されたメールアドレスは既に登録されています。');
    }

    if($_SESSION['errors']) {
        header('Location: ../../register/');
        exit;
    }

    $pdo = getDatabaseConnection();
    
    $statement = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
    $statement->bindParam(':name', htmlspecialchars($name));
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
    $statement->execute();
    
    header('Location: ../../memo/');
    exit;

}