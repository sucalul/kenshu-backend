<?php
// データの整形を行う

class ArticleEntity {
    public int $id;
    public string $title;
    public string $body;
    public string $thumbnail_image_id;
    public array $images;
    public array $tags;

    function __construct($article) {
        $this->id = $article[0]['id'];
        $this->title = $article[0]['title'];
        $this->body = $article[0]['body'];
        $this->thumbnail_image_id = $this->getThumbnailImageResourceID($article);
        $this->images = $this->getUniqueImages($article);
        $this->tags = $this->getUniqueTags($article);
    }

    // サムネイル画像のresource_idを取得
    private function getThumbnailImageResourceID(array $article) :string {
        // サムネイル画像idを取得
        $thumbnail_image_id = $article[0]['thumbnail_image_id'];
        $thumbnail_resource_id = '';
        $images = array();
        foreach ($article as $a) {
            $images[$a['image_id']] = $a['resource_id'];
        }
        $unique_images = array_unique($images);
        foreach ($unique_images as $key => $value) {
            if ($key == $thumbnail_image_id) {
                $thumbnail_resource_id = $value;
            }
        }
        return $thumbnail_resource_id;
    }

    // サムネイル以外の画像を取得
    private function getUniqueImages(array $article) :array {
        $images = array();
        foreach ($article as $a) {
            array_push($images, $a['resource_id']);
        }
        $unique_images = array_unique($images);

        $thumbnail_resource_id = $this->getThumbnailImageResourceID($article);
        $index = array_search($thumbnail_resource_id, $unique_images);
        unset($unique_images[$index]);

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
