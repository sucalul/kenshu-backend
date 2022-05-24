<?php
require_once 'models/connection.php';

class Image extends Connection {

    function __construct()
    {
        parent::__construct();
    }

    public function create(int $article_id, int $resource_id) {
        $stmt = $this->db->prepare("INSERT INTO (article_id, resource_id) values (:article_id, :resource_id);");
        $stmt->bindparam(':article_id', $article_id);
        $stmt->bindparam(':resource_id', $resource_id);
        $stmt->execute();
    }
}
