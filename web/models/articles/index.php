<?php
require_once 'models/connection.php';

class Article extends Connection {

    function __construct()
    {
        parent::__construct();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY id ASC;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByID(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM articles where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title, string $body) {
        $stmt = $this->db->prepare("INSERT INTO articles (user_id, thumbnail_image_id, title, body) VALUES (1, 1, :title, :body)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->execute();
    }

    public function update(int $id, string $title, string $body) {
        $stmt = $this->db->prepare("UPDATE articles SET title=:title, body=:body where id=:id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function delete(int $id) {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
