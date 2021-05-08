<?php

if(!isset($_SESSION)) {
    session_start();
}

// ログインチェック
function isLogin() {
    if(isset($_SESSION['user'])) {
        return true;
    }

    return false;
}

// ログイン済ユーザー名を取得
function getLoginName() {
    if(isset($_SESSION['user'])) {
        $name = $_SESSION['user']['name'];
        if(mb_strlen($name) > 7) {
            $name = mb_substr($name, 0, 7) . "…";
        }

        return $name;
    }

    return "";
}

// ログイン済ユーザーIDを取得
function getLoginId() {
    if(isset($_SESSION['user'])) {
        $id = $_SESSION['user']['id'];

        return $id;
    }

    return null;
}