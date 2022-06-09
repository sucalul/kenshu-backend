<?php
require_once 'models/Article.php';
require_once 'models/Tag.php';

class UpdateDeleteArticleHelper
{
    static function unauthorized()
    {
        return self::setErrorResponse(401);
    }

    private static function setErrorResponse(int $statusCode): void
    {
        http_response_code($statusCode);
        $_SESSION['ERRORS'] = '他のユーザーの投稿は、編集、更新、削除できません';
        header("Location: /articles");
        return;
    }

    static function hasAuthorization(array $session, int $id): bool
    {
        $connection = new Article();
        // sessionのユーザーと記事投稿したユーザーが一致しなければエラー
        if ($session['EMAIL'] !== $connection->getUserEmailByArticleID($id)[0]['email']) {
            return false;
        }
        return true;
    }
}
