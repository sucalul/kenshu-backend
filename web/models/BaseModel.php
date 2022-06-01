<?php

class BaseModel {
    public function __construct() {
        $dsn = getenv('DSN');
        $username = getenv('USERNAME');
        $password = getenv('PASSWORD');
        try {
            $db = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            printf('PDO error: ', $e->getMessage());
            exit;
        }
        $this->db = $db;
    }
}
