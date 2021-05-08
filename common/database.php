<?php

function getDatabaseConnection() {

    try {
        $pdo = new PDO('mysql:dbname=php_memo;localhost="127.0.0.1;charset=utf8;', 'root', 'root');
    } catch(PDOException $e) {
        echo 'DB接続エラー：' . $e->getMessage();
        exit;
    }

    return $pdo;

}