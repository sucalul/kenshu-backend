<?php

class Connect {
    function pdo() {
        $dsn = 'pgsql:dbname=postgres;host=db;port=5432';
        $username = 'postgres';
        $password = 'postgres';
        try {
            $db = new PDO($dsn, $username, $password);
            // echo $db;
        } catch (PDOException $e) {
            printf('PDO error: ', $e->getMessage());
            exit;
        }
        return $db;
    }
}
