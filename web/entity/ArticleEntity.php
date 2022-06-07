<?php
// データの整形を行う

class ArticleEntity {
    public int $id;
    public string $title;
    public string $body;
    public string $image_id;
    public string $thumbnail_image_id;
    public array $images;
    public array $tags;

    function __construct($article) {
        $this->id = $article[0]['id'];
        $this->title = $article[0]['title'];
        $this->body = $article[0]['body'];
        $this->image_id = $article[0]['image_id'];
        $this->thumbnail_image_id = $article[0]['thumbnail_image_id'];
        $this->images = $this->getUniqueImages($article);
        $this->tags = $this->getUniqueTags($article);
    }

    private function getUniqueImages(array $article) :array {
        $images = array();
        foreach ($article as $a) {
            array_push($images, $a['resource_id']);
        }
        $unique_images = array_unique($images);
        return $unique_images;
    }

    private function getUniqueTags(array $article) :array {
        $tags = array();
        foreach ($article as $a) {
            array_push($tags, $a['tag_name']);
        }
        $unique_tags = array_unique($tags);
        return $unique_tags;
    }

}
