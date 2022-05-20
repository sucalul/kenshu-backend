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

<?php if($errors): ?>
<ul class="error_list">
    <?php foreach( $errors as $value ): ?>
        <li><?php echo $value; ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<form action="/articles/create" method="post">
    <label class="title" for="title">title</label>
    <input id="title" type="text" name="title" required>
    <label class="body" for="body">本文</label>
    <textarea rows="4" id="body" name="body" required></textarea>
    <input type="submit" name="submit" >
</form>
</body>
</html>
