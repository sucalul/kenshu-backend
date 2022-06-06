<?php
// データの整形を行う

class ArticleEntity {
    // int id
    // string $title
    // string $body
    // array $images
    // array $tags
    public function formatArticle(array $article) :array {
        $id = $article[0]['id'];
        $title = $article[0]['title'];
        $body = $article[0]['body'];
        $images = array();
        $tags = array();
        foreach ($article as $a) {
            array_push($images, $a['resource_id']);
            array_push($tags, $a['tag_name']);
        }
        // 配列の中身をuniqueにする
        $unique_images = array_unique($images);
        $unique_tags = array_unique($tags);

        return [$id, $title, $body, $unique_images, $unique_tags];
    }
}
