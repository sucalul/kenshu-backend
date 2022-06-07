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

    public function updateArticleTags(int $id, array $tags){
        // tagを更新
        // 一致するかどうかの判定が大変そうなのでdelete->insertをする
        // まずはarticle_idが一致するarticle_tagsを削除
        // 本来ならトランザクションを貼るべきだが、
        // 親のArticleでトランザクションを貼っているからトランザクションは貼らなくても良い
        $sql_article_tags_delete = "DELETE
                                    FROM
                                        article_tags
                                    WHERE
                                        article_id = :article_id
                                    ;";
        $stmt_article_tags_delete = $this->db->prepare($sql_article_tags_delete);
        $stmt_article_tags_delete->bindParam(':article_id', $id);
        $stmt_article_tags_delete->execute();
        // 次にinsert
        $sql_article_tags_insert = "INSERT INTO article_tags(
                                            article_id,
                                            tag_id
                                        )
                                        VALUES(
                                            :article_id,
                                            :tag_id
                                        )
                                        ;";
        foreach ($tags as $tag) {
            $stmt_article_tags = $this->db->prepare($sql_article_tags_insert);
            $stmt_article_tags->bindParam(':article_id', $id);
            $stmt_article_tags->bindParam(':tag_id', $tag);
            $stmt_article_tags->execute();
        }
        return;
    }
}
