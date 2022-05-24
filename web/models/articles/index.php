<?php
require_once 'models/connection.php';

class Article extends Connection {

    function __construct()
    {
        parent::__construct();
    }

    public function getAll() {
        // 初期データの入れ方変える
        $stmt = $this->db->prepare("SELECT * FROM articles JOIN article_images ON articles.id = article_images.article_id ORDER BY articles.id ASC;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByID(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM articles where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title, string $body, array $resources) {
        // TODO:
        // - 複数枚投稿 ✅
        // - サムネ選択
        // - タグ表示
        // - タグ選択
        // - タグ保存
        //txまとめる
        $this->db->beginTransaction();
        $stmt = $this->db->prepare("INSERT INTO articles (user_id, thumbnail_image_id, title, body) VALUES (1, NULL, :title, :body)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->execute();
        $article_id = $this->db->lastInsertId();
        // 画像をinsert
        foreach ($resources as $resource_id) {
            $stmt_images = $this->db->prepare("INSERT INTO article_images (article_id, resource_id) VALUES (:article_id, :resource_id)");
            $stmt_images->bindparam(':article_id', $article_id);
            $stmt_images->bindparam(':resource_id', $resource_id);
            $stmt_images->execute();
        }
        $thumbnail_image_id = $this->db->lastInsertId();
        // 画像をいれたのでarticleの更新処理をする
        $stmt_article = $this->db->prepare("UPDATE articles SET thumbnail_image_id=:thumbnail_image_id where id=:id");
        $stmt_article->bindParam(':thumbnail_image_id', $thumbnail_image_id);
        $stmt_article->bindParam(':id', $article_id);
        $stmt_article->execute();
        $this->db->commit();
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
