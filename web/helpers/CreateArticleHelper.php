<?php
require_once 'models/Tag.php';

class CreateArticleHelper
{
    static function badRequest(array $errorList): void
    {
        $errors = $errorList;
        http_response_code(400);
        $tag_connection = new Tag();
        $tags = $tag_connection->getAll();
        include 'templates/articles/articleCreate.php';
        return;
    }
}
