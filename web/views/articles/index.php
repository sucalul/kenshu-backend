
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
        // check_csrf_token()で設定されたstatus codeを返す
        return http_response_code();
    }

    $connection = new Article();
    $title = $_POST['title'];
    $body = $_POST['body'];

    //$image = $_POST['image'];

    //$image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    //error_log($image);
    //$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    //error_log($image);
    //$img_name = $_FILES['image']['name'];
    //move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $img_name);
    // ファイルの保存先
    $filename = uniqid().'png';

    move_uploaded_file($_FILES['upload_csv']['tmp_name'], '../../templates/images/'.$filename);
    error_log('../../templates/images/'.$filename);
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
        $connection->create($title, $body);
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
        // check_csrf_token()で設定されたstatus codeを返す
        return http_response_code();
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
        // check_csrf_token()で設定されたstatus codeを返す
        return http_response_code();
    }
    $connection = new Article();
    $connection->delete($id);
    header("Location: /articles");
}
