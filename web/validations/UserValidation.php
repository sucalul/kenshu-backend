<?php
require_once 'models/User.php';

class UserValidation
{

    static function userValidation(array $post): array
    {
        $errors = [];
        // 空白文字チェック
        $pattern = "^(\s|　)+$";
        if (mb_ereg_match($pattern, $post['name'])) {
            $errors[] = '名前は必須です。';
        }
        if (mb_ereg_match($pattern, $post['email'])) {
            $errors[] = 'メールアドレスは必須です。';
        }
        if (mb_ereg_match($pattern, $post['password'])) {
            $errors[] = 'パスワード必須です。';
        }
        // メールアドレスがすでに存在するかチェック
        $connection = new User();
        $count = $connection->getUserByEmail($post['email']);
        if (count($count) > 0) {
            $errors[] = 'このメールアドレスはすでに使われています。';
        }

        return $errors;
    }
}
