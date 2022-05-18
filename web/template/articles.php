<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<?php foreach($items as $item) : ?>
    <a href=""></a>
    <h3><?= $item['id'] ?></h3>
    <h3><?= $item['title'] ?></h3>
    <button type="button" class="btn btn-info" onclick="location.href='/articles/<?= $item['id'] ?>'">More</button>
<?php endforeach; ?>

</body>
</html>
