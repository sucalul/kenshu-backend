<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
    <h3><?= $article['id'] ?></h3>
    <img src="../template/images/<?= $article['thumbnail_image_id'] ?>.png" alt="" style="width:200px; height:200px">
    <h3><?= $article['title'] ?></h3>
    <p><?= $article['body'] ?></p>
</body>
</html>
