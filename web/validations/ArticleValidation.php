<?php

class ArticleValidation {

    static function articleValidation(array $post) :array {
        $errors = [];
        // 空白文字チェック
        $pattern="^(\s|　)+$";
        if (mb_ereg_match($pattern, $post['title'])) {
            $errors[] = 'タイトルは必須です。';
        }
        if (mb_ereg_match($pattern, $post['body'])) {
            $errors[] = '本文は必須です。';
        }
        // タグ未入力チェック
        if (!isset($post['tags'])) {
            $errors[] = 'タグは一つ以上入れてください。';
        }

        return $errors;
    }
}
