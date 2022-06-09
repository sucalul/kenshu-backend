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
}

