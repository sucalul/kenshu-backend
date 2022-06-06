<?php

class ThumbnailHelper {
    static function checkThumbnail(string $thumbnail_resource) :array {
        for ($i = 0; $i < count($_FILES['upload_image']['name']); $i++) {
            // file名をuniqueにする
            $resource = uniqid();
            $resources[] = $resource;
            //サムネイル登録されているファイル名とforで回しているファイル名が一致したらサムネイルとして登録処理する
            if (isset($_POST['is-thumbnail']) && $_POST['is-thumbnail'] == $_FILES['upload_image']['name'][$i]) {
                $thumbnail_resource = $resource;
                $index = array_search($thumbnail_resource, $resources);
                array_splice($resources, $index, 1);
            }
            // upload先指定
            $uploaded_path = 'templates/images/'.$resource.'.png';
            // fileの移動
            move_uploaded_file($_FILES['upload_image']['tmp_name'][$i], $uploaded_path);
        }
        // サムネイルが登録されていなければ一つ目の画像をサムネイルとする
        if (empty($thumbnail_resource)) {
            $thumbnail_resource = current($resources);
            $index = array_search($thumbnail_resource, $resources);
            array_splice($resources, $index, 1);
        }

        return [$resources, $thumbnail_resource];
    }
}
