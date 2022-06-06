
<?php
require_once 'entity/ArticleEntity.php';
require_once 'models/Article.php';
require_once 'models/Tag.php';
require_once 'helpers/Session.php';
require_once 'helpers/ThumbnailHelper.php';

// TODO: class化 -> やるかどうか迷う

function articleList() {
    $session = new Session();
    $csrf_token = $session->create_csrf_token();
    $connection = new Article();
    $articles = $connection->getAll();
    include 'templates/articles/articles.php';
}

function articleDetail(int $id) {
    $session = new Session();
    $csrf_token = $session->create_csrf_token();
    $connection = new Article();
    $article = $connection->getByID($id);
    if (count($article) === 0) {
        http_response_code(404);
        include 'templates/404.php';
        return;
    }

    $articleEntity = new ArticleEntity($article);

    include 'templates/articles/articleDetail.php';
}

function getArticleCreate() {
    $errors = [];
    $session = new Session();
    $csrf_token = $session->create_csrf_token();
    $connection = new Tag();
    $tags = $connection->getAll();
    include 'templates/articles/articleCreate.php';
}

function postArticleCreate() {
    $errors = [];
    $session = new Session();
    if (!$session->check_csrf_token()) {
        return;
    }

    $connection = new Article();
    $title = $_POST['title'];
    $body = $_POST['body'];
    $thumbnail_resource = '';
    // 空白文字チェック
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
    }

    $tags = $_POST['tags'];

    list($resources, $thumbnail_resource) = ThumbnailHelper::checkThumbnail($thumbnail_resource);
    $connection->create($title, $body, $resources, $thumbnail_resource, $tags);
    header("Location: /articles");
}

function getArticleUpdate(int $id) {
    $errors = [];
    $session = new Session();
    $csrf_token = $session->create_csrf_token();

    $connection = new Article();
    $article = $connection->getByID($id);
    $tag_connection = new Tag();
    $tags = $tag_connection->getByArticleId($id);


    if (count($article) === 0) {
        http_response_code(404);
        include 'templates/404.php';
        return;
    }
    include 'templates/articles/articleUpdate.php';
}

function postArticleUpdate(int $id) {
    $errors = [];
    $session = new Session();
    if (!$session->check_csrf_token()) {
        return;
    }

    $connection = new Article();
    $title = $_POST['title'];
    $body = $_POST['body'];
    $thumbnail_resource = $_POST['is-thumbnail'];

    //  空白文字チェック
    $pattern="^(\s|　)+$";
    if (mb_ereg_match($pattern, $title)) {
        $errors[] = 'タイトルは必須です。';
    }
    if (mb_ereg_match($pattern, $body)) {
        $errors[] = '本文は必須です。';
    }
    if (count($errors) > 0) {
        http_response_code(400);
        include 'templates/articles/articleUpdate.php';
        return;
    }

    // 追加の画像なかった時
    if (empty($_FILES['upload_image']['name'][0])) {
        $connection->updateExceptImages($id, $title, $body, $thumbnail_resource);
        header("Location: /articles");
        return;
    }

    // 追加の画像がある時
    list($resources, $thumbnail_resource) = ThumbnailHelper::checkThumbnail($thumbnail_resource);

    $connection->update($id, $title, $body, $resources, $thumbnail_resource);
    header("Location: /articles");
    return;
}

function articleDelete(int $id) {
    $session = new Session();
    if (!$session->check_csrf_token()) {
        return;
    }
    $connection = new Article();
    $connection->delete($id);
    header("Location: /articles");
}
