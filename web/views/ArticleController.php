<?php
require_once 'entity/ArticleEntity.php';
require_once 'models/Article.php';
require_once 'models/Tag.php';
require_once 'helpers/CreateArticleHelper.php';
require_once 'helpers/Session.php';
require_once 'helpers/ThumbnailHelper.php';
require_once 'helpers/UpdateArticleHelper.php';
require_once 'validations/ArticleValidation.php';

class ArticleController
{
    // TODO: この研修期間では対応なし
    // Request classを作成
    // ref: https://prtimes.slack.com/archives/CBJSBCTF1/p1654590765982449?thread_ts=1654568652.844449&cid=CBJSBCTF1
    public function articleList()
    {
        $session = new Session();
        $csrf_token = $session->createCSRFToken();
        $connection = new Article();
        $articles = $connection->getAll();
        include 'templates/articles/articles.php';
    }

    public function articleDetail(int $id)
    {
        $session = new Session();
        $csrf_token = $session->createCSRFToken();
        // ERRORSのsessionを消す
        unset($_SESSION['ERRORS']);
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

    public function getArticleCreate()
    {
        $errors = [];
        $session = new Session();
        $csrf_token = $session->createCSRFToken();
        $connection = new Tag();
        $tags = $connection->getAll();
        include 'templates/articles/articleCreate.php';
    }

    public function postArticleCreate()
    {
        $errors = [];
        $session = new Session();
        if (!$session->checkCSRFToken()) {
            return;
        }

        // ここでsignin check
        // そもそもsetされているか確認
        if (!isset($_SESSION['EMAIL'])) {
            $errors[] = 'ログインが必要です';
            return CreateArticleHelper::unauthorized($errors);
        }

        $connection = new Article();
        $title = $_POST['title'];
        $body = $_POST['body'];
        $email = $_SESSION['EMAIL'];
        $thumbnail_resource = '';

        $errors = ArticleValidation::validate($_POST);
        if (count($errors) > 0) {
            return CreateArticleHelper::badRequest($errors);
        }

        $tags = $_POST['tags'];

        list($resources, $thumbnail_resource) = ThumbnailHelper::checkThumbnail($_POST, $_FILES);
        $connection->create($email, $title, $body, $resources, $thumbnail_resource, $tags);
        header("Location: /articles");
    }

    public function getArticleUpdate(int $id)
    {
        $errors = [];
        $session = new Session();
        $csrf_token = $session->createCSRFToken();

        $connection = new Article();
        $article = $connection->getByID($id);

        // ログインチェック
        // そもそもsetされているか確認
        if (!isset($_SESSION['EMAIL'])) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        $connection = new Article();

        // sessionのユーザーと記事投稿したユーザーが一致しなければエラー
        if (!UpdateDeleteArticleHelper::hasAuthorization($_SESSION, $id)) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        if (count($article) === 0) {
            http_response_code(404);
            include 'templates/404.php';
            return;
        }

        $tag_connection = new Tag();
        $all_tags = $tag_connection->getAll();

        $articleEntity = new ArticleEntity($article);

        include 'templates/articles/articleUpdate.php';
    }

    public function postArticleUpdate(int $id)
    {
        $errors = [];
        $session = new Session();
        if (!$session->checkCSRFToken()) {
            return;
        }

        // ログインチェック
        // そもそもsetされているか確認
        if (!isset($_SESSION['EMAIL'])) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        $connection = new Article();
        // sessionのユーザーと記事投稿したユーザーが一致しなければエラー
        if (!UpdateDeleteArticleHelper::hasAuthorization($_SESSION, $id)) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        $title = $_POST['title'];
        $body = $_POST['body'];
        $thumbnail_resource = $_POST['is-thumbnail'];

        $errors = ArticleValidation::validate($_POST);
        if (count($errors) > 0) {
            http_response_code(400);
            $article = $connection->getByID($id);
            $tag_connection = new Tag();
            $all_tags = $tag_connection->getAll();

            $articleEntity = new ArticleEntity($article);

            include 'templates/articles/articleUpdate.php';
            return;
        }

        $tags = $_POST['tags'];

        // 追加の画像なかった時
        if (empty($_FILES['upload_image']['name'][0])) {
            $connection->updateExceptImages($id, $title, $body, $thumbnail_resource, $tags);
            header("Location: /articles");
            return;
        }

        // 追加の画像がある時
        list($resources, $thumbnail_resource) = ThumbnailHelper::checkThumbnail($_POST, $_FILES);

        $connection->update($id, $title, $body, $resources, $thumbnail_resource, $tags);
        header("Location: /articles");
        return;
    }

    public function articleDelete(int $id)
    {
        $session = new Session();
        if (!$session->checkCSRFToken()) {
            return;
        }

        // ログインチェック
        // そもそもsetされているか確認
        if (!isset($_SESSION['EMAIL'])) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        $connection = new Article();
        // sessionのユーザーと記事投稿したユーザーが一致しなければエラー
        if (!UpdateDeleteArticleHelper::hasAuthorization($_SESSION, $id)) {
            return UpdateDeleteArticleHelper::unauthorized();
        }

        $connection->delete($id);
        header("Location: /articles");
    }
}
