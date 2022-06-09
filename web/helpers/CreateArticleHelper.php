<?php
require_once 'models/Tag.php';

class CreateArticleHelper
{
    static function badRequest(array $errorList)
    {
        return self::baseHelper($errorList, 400);
    }

    static function unauthorized(array $errorList)
    {
        return self::baseHelper($errorList, 401);
    }

    private static function baseHelper(array $errorList, int $statusCode): void
    {
        $errors = $errorList;
        http_response_code($statusCode);
        $tag_connection = new Tag();
        $tags = $tag_connection->getAll();
        include 'templates/articles/articleCreate.php';
        return;
    }
}
