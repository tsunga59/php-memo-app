<?php

session_start();

require('../../common/validation.php');
require('../../common/database.php');

if(!empty($_POST)) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    //バリデーション
    $_SESSION['errors'] = [];
    
    // 空チェック
    emptyCheck($_SESSION['errors'], $email, 'メールアドレスを入力してください。');
    emptyCheck($_SESSION['errors'], $password, 'パスワードを入力してください。');

    // 文字数
    stringMaxCheck($_SESSION['errors'], $email, 'メールアドレスは255文字以内で入力しください。');
    stringMaxCheck($_SESSION['errors'], $password, 'パスワードは255文字以内で入力しください。');
    stringMinCheck($_SESSION['errors'], $password, 'パスワードは8文字以上で入力してください。');

    if(!$_SESSION['errors']) {
        // メールアドレスチェック
        emailCheck($_SESSION['errors'], $email, '正しいメールアドレスを入力してください。');
    
        // 半角英数字チェック
        stringTypeCheck($_SESSION['errors'], $password, 'パスワードは半角英数字で入力してください。');
    }

    if($_SESSION['errors']) {
        header('Location: ../../login/');
        exit;
    }

    $pdo = getDatabaseConnection();

    $statement = $pdo->prepare('SELECT id, name, password FROM users WHERE email = :email');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if(!$user) {
        $_SESSION['errors'] = ['メールアドレスまたはパスワードが正しくありません。'];
        header('Location: ../../login/');
        exit;
    }

    $name = $user['name'];
    $id = $user['id'];

    if(password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'name' => $name,
            'id' => $id,
        ];

        $statement = $pdo->prepare('SELECT id, title, content FROM memos WHERE user_id = :user_id ORDER BY updated_at DESC LIMIT 1');
        $statement->bindParam(':user_id', $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result) {
            $_SESSION['selected_memo'] = [
                'id' => $result['id'],
                'title' => $result['title'],
                'content' => $result['content'],
            ];
        }

        header('Location: ../../memo/');
        exit;
    } else {
        $_SESSION['errors'] = ['メールアドレスまたはパスワードが正しくありません。'];
        header('Location: ../../login/');
        exit;
    }

}