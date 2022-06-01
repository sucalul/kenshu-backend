<?php
require_once 'models/BaseModel.php';

class Article extends BaseModel {

    function __construct()
    {
        parent::__construct();
    }

    public function getAll() {
        // 同じカラム名(id)がふたつ帰ってくるからasで対応
        $sql = "SELECT
                    articles.id as id,
                    articles.title as title,
                    article_images.resource_id as resource_id
                FROM
                    articles
                    JOIN
                        article_images
                    ON  articles.id = article_images.article_id
                WHERE
                    articles.thumbnail_image_id = article_images.id
                ORDER BY
                    articles.id ASC
                ;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByID(int $id) {
        $sql = "SELECT
                    articles.id as id,
                    articles.title as title,
                    articles.body as body,
                    article_images.resource_id as resource_id
                FROM
                    articles
                    JOIN
                        article_images
                    ON  articles.id = article_images.article_id
                WHERE
                    articles.id = :id
                ;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title, string $body, array $resources, string $thumbnail_resource) {
        // TODO:
        // - 複数枚投稿 ✅
        // - サムネ選択 ✅
        // - タグ表示
        // - タグ選択
        // - タグ保存
        //txまとめる
        try {
            $this->db->beginTransaction();
            $stmt_articles = $this->db->prepare("INSERT INTO articles (user_id, thumbnail_image_id, title, body) VALUES (1, NULL, :title, :body)");
            $stmt_articles->bindParam(':title', $title);
            $stmt_articles->bindParam(':body', $body);
            $stmt_articles->execute();
            $article_id = $this->db->lastInsertId();

            // サムネイル画像をinsert
            $stmt_article_images_thumbnail = $this->db->prepare("INSERT INTO article_images (article_id, resource_id) VALUES (:article_id, :resource_id)");
            $stmt_article_images_thumbnail->bindParam(':article_id', $article_id);
            $stmt_article_images_thumbnail->bindParam(':resource_id', $thumbnail_resource);
            $stmt_article_images_thumbnail->execute();
            $thumbnail_image_id = $this->db->lastInsertId();

            // サムネイル以外の画像をinsert
            foreach ($resources as $resource_id) {
                $stmt_article_images = $this->db->prepare("INSERT INTO article_images (article_id, resource_id) VALUES (:article_id, :resource_id)");
                $stmt_article_images->bindParam(':article_id', $article_id);
                $stmt_article_images->bindParam(':resource_id', $resource_id);
                $stmt_article_images->execute();
            }

            // 画像をいれたのでarticleの更新処理をする
            $stmt_article = $this->db->prepare("UPDATE articles SET thumbnail_image_id=:thumbnail_image_id where id=:id");
            $stmt_article->bindParam(':thumbnail_image_id', $thumbnail_image_id);
            $stmt_article->bindParam(':id', $article_id);
            $stmt_article->execute();
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
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
