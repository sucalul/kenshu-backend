<?php
require_once 'models/connection.php';

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

    public function create($title, $body) {
        $stmt = $this->db->prepare("INSERT INTO articles (user_id, thumbnail_image_id, title, body) VALUES (1, 1, :title, :body)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->execute();
    }
}