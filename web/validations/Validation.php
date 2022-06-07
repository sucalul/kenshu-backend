<?php

class Validation {
    public array $errors;

    function __construct() {
        $this->errors = $this->articleValidation();
    }

    public function articleValidation() :array {
        $errors = [];
        // 空白文字チェック
        $pattern="^(\s|　)+$";
        if (mb_ereg_match($pattern, $_POST['title'])) {
            $errors[] = 'タイトルは必須です。';
        }
        if (mb_ereg_match($pattern, $_POST['body'])) {
            $errors[] = '本文は必須です。';
        }
        // タグ未入力チェック
        if (!isset($_POST['tags'])) {
            $errors[] = 'タグは一つ以上入れてください。';
        }

        return $errors;
    }
}
