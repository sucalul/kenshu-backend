<?php
require_once 'models/User.php';

class UserValidation
{

    static function signupValidate(array $post): array
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
        $user = $connection->getUserByEmail($post['email']);
        if (count($user) > 0) {
            $errors[] = 'このメールアドレスはすでに使われています。';
        }

        return $errors;
    }

    static function signinValidate(array $post): array
    {
        $errors = [];
        // 空白文字チェック
        $pattern = "^(\s|　)+$";
        if (mb_ereg_match($pattern, $post['email'])) {
            $errors[] = 'メールアドレスは必須です。';
        }
        if (mb_ereg_match($pattern, $post['password'])) {
            $errors[] = 'パスワード必須です。';
        }
        $connection = new User();
        $user = $connection->getUserByEmail($post['email']);
        // メールアドレスに紐づくユーザーがいない、または紐づくユーザーのパスワードが間違っている
        if (count($user) === 0 || !password_verify($post['password'], $user[0]['password'])) {
            $errors[] = 'メールアドレスまたはパスワードが間違っています。';
        }

        return $errors;
    }
}
