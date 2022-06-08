<?php

class Session {
    // TODO
    // 関数名がpythonチックなのでphpに合わせるcreateCsrcToken()
    function create_csrf_token() {
        session_start();
        $csrf_token = bin2hex(openssl_random_pseudo_bytes(16));
        $_SESSION["csrf_token"] = $csrf_token;
        return $csrf_token;
    }

    function check_csrf_token() {
        session_start();
        if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
            http_response_code(403);
            include 'templates/403.php';
            return;
        }
        return true;
    }
}
