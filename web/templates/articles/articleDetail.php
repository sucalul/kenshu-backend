<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
    <h3><?= htmlspecialchars($article['id'], ENT_QUOTES, "UTF-8") ?></h3>
    <img src="../templates/images/<?= htmlspecialchars($article['thumbnail_image_id'], ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
    <h3><?= htmlspecialchars($article['title'], ENT_QUOTES, "UTF-8") ?></h3>
    <h3><?= htmlspecialchars($article['body'], ENT_QUOTES, "UTF-8") ?></h3>
    <a href="/articles/<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>/update">Edit</a>
    <form action="/articles/<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>/delete" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <button type="submit">Delete</button>
    </form>
</body>
</html>
