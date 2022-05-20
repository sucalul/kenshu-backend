
<?php
require_once 'model/connection.php';
require_once 'model/articles.php';

// TODO: class化 -> やるかどうか迷う

function articleList() {
    $connection = new Article();
    $articles = $connection->getAll();
    if (count($articles) === 0) {
        echo 'まだ記事はないよ';
        return http_response_code(404);
    }
    include 'template/articles.php';
}

function articleDetail($id) {
    $connection = new Article();
    $article = $connection->getByID($id);
    if (count($article) === 0) {
        echo 'その記事ないよ';
        return http_response_code(404);
    }
    $article = $article[0];
    include 'template/articleDetail.php';
}

function articleCreate() {
    $connection = new Article();
    $title = $_POST['title'];
    $body = $_POST['body'];
    // TODO: validation

    $errors = [];
    //  空白文字チェック
    $pattern="^(\s|　)+$";
    if (mb_ereg_match($pattern, $title)) {
        $errors[] = 'タイトルは必須です。';
    }
    if (mb_ereg_match($pattern, $body)) {
        $errors[] = '本文は必須です。';
    }
    if (count($errors) > 0) {
        // TODO: ここまでで取得した$errorsをどのようにフロントに表示させるか
        return;
    }

    $connection->create($title, $body);
    header("Location: /articles");
    exit;
}
