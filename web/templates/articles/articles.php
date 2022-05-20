<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<?php foreach($articles as $article) : ?>
    <h3><?= $article['id'] ?></h3>
    <img src="../template/images/<?= $article['thumbnail_image_id'] ?>.png" alt="" style="width:200px; height:200px">
    <h3><?= $article['title'] ?></h3>
    <button type="button" class="btn btn-info" onclick="location.href='/articles/<?= $article['id'] ?>'">More</button>
    <p>-------------------------</p>
<?php endforeach;?>
<button type="button" onclick="location.href='/articles/create'">新規作成</button>
</body>
</html>
