
<?php
require_once 'models/connection.php';
require_once 'models/articles/index.php';
require_once 'helpers/session.php';
require_once 'models/images/index.php';

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
    $article = $article[0];
    include 'templates/articles/articleDetail.php';
}

function getArticleCreate() {
    $errors = [];
    $session = new Session();
    $csrf_token = $session->create_csrf_token();
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
    $resources = array();
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
    } else {
        error_log($_POST['is-thumbnail']);
        error_log(count($_FILES['upload_image']['name']));
        for ($i = 0; $i < count($_FILES['upload_image']['name']); $i++) {
            if (isset($_POST['is-thumbnail'])) {
                
            }
            // file名をuniqueにする
            $resource = uniqid();
            $resources[] = $resource;
            // upload先指定
            $uploaded_path = 'templates/images/'.$resource.'.png';
            // fileの移動
            move_uploaded_file($_FILES['upload_image']['tmp_name'][$i], $uploaded_path);
        }
        $connection->create($title, $body, $resources);
        header("Location: /articles");
        exit;
    }
}

function getArticleupdate(int $id) {
    $errors = [];
    $session = new Session();
    $csrf_token = $session->create_csrf_token();

    $connection = new Article();
    $article = $connection->getByID($id);
    $article = $article[0];
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
    //  空白文字チェック

    $pattern="^(\s|　)+$";
    if (mb_ereg_match($pattern, $title)) {
        $errors[] = 'タイトルは必須です。';
    }
    if (mb_ereg_match($pattern, $body)) {
        $errors[] = '本文は必須です。';
    }
    if (count($errors) > 0) {
        http_response_code(204);
        include 'templates/articles/articleUpdate.php';
        return;
    } else {
        $connection->update($id, $title, $body);
        header("Location: /articles");
        return;
    }
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
