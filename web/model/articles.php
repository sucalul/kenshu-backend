<?php
require_once 'model/connection.php';

class Article extends Connection {

    function __construct()
    {
        parent::__construct();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM articles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByID($id) {
        $stmt = $this->db->prepare("SELECT * FROM articles where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
