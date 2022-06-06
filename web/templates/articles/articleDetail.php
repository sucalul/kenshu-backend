<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
    <h3><?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?></h3>
    <?php foreach($images as $image) : ?>
        <img src="../../templates/images/<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
    <?php endforeach;?>
    <h3><?= htmlspecialchars($title, ENT_QUOTES, "UTF-8") ?></h3>
    <h3><?= htmlspecialchars($body, ENT_QUOTES, "UTF-8") ?></h3>
    <p>登録しているタグ</p>
    <ul>
        <?php foreach($tags as $tag) : ?>
            <li><?= htmlspecialchars($tag, ENT_QUOTES, "UTF-8") ?></li>
        <?php endforeach;?>
    </ul>
    <a href="/articles/<?= htmlspecialchars($article[0]['id'], ENT_QUOTES, 'UTF-8') ?>/update">Edit</a>
    <form action="/articles/<?= htmlspecialchars($article[0]['id'], ENT_QUOTES, 'UTF-8') ?>/delete" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <button type="submit">Delete</button>
    </form>
</body>
</html>
