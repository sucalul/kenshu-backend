<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
    <h3><?= htmlspecialchars($article[0]['id'], ENT_QUOTES, "UTF-8") ?></h3>
    <?php foreach($article as $article_image) : ?>
        <img src="../templates/images/<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
    <?php endforeach;?>
    <h3><?= htmlspecialchars($article[0]['title'], ENT_QUOTES, "UTF-8") ?></h3>
    <h3><?= htmlspecialchars($article[0]['body'], ENT_QUOTES, "UTF-8") ?></h3>
    <a href="/articles/<?= htmlspecialchars($article[0]['id'], ENT_QUOTES, 'UTF-8') ?>/update">Edit</a>
    <form action="/articles/<?= htmlspecialchars($article[0]['id'], ENT_QUOTES, 'UTF-8') ?>/delete" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <button type="submit">Delete</button>
    </form>
</body>
</html>
