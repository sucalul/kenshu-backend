<?php
require_once 'helpers/Session.php';
require_once 'helpers/SigninHelper.php';
require_once 'models/User.php';
require_once 'validations/UserValidation.php';

class AuthController
{
    public function getSignup(): void
    {
        $errors = [];
        $session = new Session();
        $csrf_token = $session->create_csrf_token();
        include 'templates/signup.php';
        return;
    }

    public function postSignup(): void
    {
        $errors = [];
        $session = new Session();
        if (!$session->check_csrf_token()) {
            return;
        }

        $errors = UserValidation::signupValidate($_POST);
        if (count($errors) > 0) {
            http_response_code(400);
            include 'templates/signup.php';
            return;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // 画像がない時はデフォルトで1入れる
        if (empty($_FILES['profile_image']['name'])) {
            $profile_resource_id = 1;
        } else {
            $profile_resource_id = uniqid();
            $uploaded_path = 'templates/images/users/' . $profile_resource_id . '.png';
            // fileの移動
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploaded_path);
        }

        $connection = new User();
        $connection->create($name, $email, $password, $profile_resource_id);
        // sessionに$emailを入れる
        // これをみてログインしてるか確認する
        $_SESSION['EMAIL'] = $email;

        header("Location: /articles");
    }

    public function getSignin(): void
    {
        $errors = [];
        $session = new Session();
        $csrf_token = $session->create_csrf_token();
        include 'templates/signin.php';
        return;
    }

    public function postSignin(): void
    {
        $errors = [];
        $session = new Session();
        if (!$session->check_csrf_token()) {
            return;
        }

        $errors = SigninHelper::signin($_POST);
        if (count($errors) > 0) {
            http_response_code(400);
            include 'templates/signin.php';
            return;
        }

        // 前のセッションを消す
        session_regenerate_id(true);
        $_SESSION['EMAIL'] = $_POST['email'];

        header("Location: /articles");
    }
}
