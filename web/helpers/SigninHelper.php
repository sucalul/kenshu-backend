<?php
require_once 'models/User.php';


class SigninHelper
{
    static function signin(array $post): array
    {
        $errors = [];
        $connection = new User();
        $user = $connection->getUserByEmail($post['email']);
        // メールアドレスに紐づくユーザーがいない、または紐づくユーザーのパスワードが間違っている
        if (count($user) === 0 || !password_verify($post['password'], $user[0]['password'])) {
            $errors[] = 'メールアドレスまたはパスワードが間違っています。';
        }

        return $errors;
    }

    static function signinRequired(string $email): array
    {
        $errors = [];
        $connection = new User();
        $user = $connection->getUserByEmail($email);

        if (count($user) == 0) {
            $errors = 'ログインが必要です';
        }

        return $errors;
    }
}

