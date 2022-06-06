<?php
require_once 'models/BaseModel.php';

class Tag extends BaseModel
{

    function __construct()
    {
        parent::__construct();
    }

    public function getAll() {
        $sql = "SELECT * FROM tags;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByArticleId(int $article_id) {
        $sql = "SELECT
                    name
                FROM
                    article_tags
                    JOIN
                        tags
                    ON  article_tags.tag_id = tags.id
                WHERE
                    article_id = :id
                ;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $article_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
