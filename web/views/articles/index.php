
<?php
require_once 'models/Article.php';
require_once 'helpers/Session.php';

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
    for ($i = 0; $i < count($_FILES['upload_image']['name']); $i++) {
        // file名をuniqueにする
        $resource = uniqid();
        $resources[] = $resource;
        //サムネイル登録されているファイル名とforで回しているファイル名が一致したらサムネイルとして登録処理する
        if (isset($_POST['is-thumbnail']) && $_POST['is-thumbnail'] == $_FILES['upload_image']['name'][$i]) {
            $thumbnail_resource = $resource;
            $index = array_search($thumbnail_resource, $resources);
            array_splice($resources, $index, 1);
        }
        // upload先指定
        $uploaded_path = 'templates/images/'.$resource.'.png';
        // fileの移動
        move_uploaded_file($_FILES['upload_image']['tmp_name'][$i], $uploaded_path);
    }
    // サムネイルが登録されていなければ一つ目の画像をサムネイルとする
    if (empty($thumbnail_resource)) {
        $thumbnail_resource = current($resources);
        $index = array_search($thumbnail_resource, $resources);
        array_splice($resources, $index, 1);
    }
    $connection->create($title, $body, $resources, $thumbnail_resource);
    header("Location: /articles");
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
