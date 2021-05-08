<?php

function getHeader($title) {

    return <<<EOF

    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <!-- css -->
        <link rel="stylesheet" type="text/css" href="../public/css/style.css">
        <title>Memo_app | {$title}</title>
    </head>
    
    <body>

    EOF;

}
