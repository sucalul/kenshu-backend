
<?php
require_once 'models/connection.php';
require_once 'models/articles/index.php';

// TODO: class化 -> やるかどうか迷う

function articleList() {
    $connection = new Article();
    $articles = $connection->getAll();
    include 'templates/articles/articles.php';
}

function articleDetail($id) {
    $connection = new Article();
    $article = $connection->getByID($id);
    if (count($article) === 0) {
        include 'templates/404.php';
        return;
    }
    $article = $article[0];
    include 'templates/articles/articleDetail.php';
}

function articleCreate() {
    $errors = [];
    // post requestが飛んできた時
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connection = new Article();
        $title = $_POST['title'];
        $body = $_POST['body'];
        //  空白文字チェック
        $pattern="^(\s|　)+$";
        if (mb_ereg_match($pattern, $title)) {
            $errors[] = 'タイトルは必須です。';
        }
        if (mb_ereg_match($pattern, $body)) {
            $errors[] = '本文は必須です。';
        }
        if (count($errors) > 0) {
            include 'templates/articles/articleCreate.php';
            return;
        } else {
            $connection->create($title, $body);
            header("Location: /articles");
            exit;
        }
    }
    // それ以外はtemplateを返す
    include 'templates/articles/articleCreate.php';

}
