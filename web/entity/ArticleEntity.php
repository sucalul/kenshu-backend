<?php
// データの整形を行う

class ArticleEntity {
    public int $id;
    public string $title;
    public string $body;
    public array $images;
    public array $tags;

    function __construct($article) {
        $this->id = $this->getID($article);
        $this->title = $this->getTitle($article);
        $this->body = $this->getBody($article);
        $this->images = $this->getImages($article);
        $this->tags = $this->getTags($article);
    }

    public function getID(array $article) :int {
        return $article[0]['id'];
    }

    public function getTitle(array $article) :string {
        return $article[0]['title'];
    }

    public function getBody(array $article) :string {
        return $article[0]['body'];
    }

    public function getImages(array $article) :array {
        $images = array();
        foreach ($article as $a) {
            array_push($images, $a['resource_id']);
        }
        $unique_images = array_unique($images);
        return $unique_images;
    }
    public function getTags(array $article) :array {
        $tags = array();
        foreach ($article as $a) {
            array_push($tags, $a['tag_name']);
        }
        $unique_tags = array_unique($tags);
        return $unique_tags;
    }

}
