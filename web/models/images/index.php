<?php
require_once 'models/connection.php';

class Image extends Connection {

    function __construct()
    {
        parent::__construct();
    }

    public function create(int $article_id, int $resource_id) {
        $stmt = $this->db->prepare("INSERT INTO (article_id, resource_id) values (:article_id, :resource_id);");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->bindParam(':resource_id', $resource_id);
        $stmt->execute();
    }

    public function getByArticleId(int $article_id) {
        $stmt = $this->db->prepare("SELECT resource_id FROM article_images WHERE article_id = :article_id;");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
