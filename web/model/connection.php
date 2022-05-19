<?php

class Connection {
    public function __construct() {
        $dsn = 'pgsql:dbname=postgres;host=db;port=5432';
        $username = 'postgres';
        $password = 'postgres';
        try {
            $db = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            printf('PDO error: ', $e->getMessage());
            exit;
        }
        $this->db = $db;
    }
}
