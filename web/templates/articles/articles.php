<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<?php include 'templates/session.php'; ?>

<?php if(isset($_SESSION['ERRORS'])): ?>
<ul class="error_list">
    <li style="color:red"><?= htmlspecialchars($_SESSION['ERRORS'], ENT_QUOTES, "UTF-8") ?></li>
</ul>
<?php endif; ?>

<?php foreach ($articles as $article) : ?>
    <h3><?= htmlspecialchars($article['id'], ENT_QUOTES, "UTF-8") ?></h3>
    <img src="../templates/images/<?= htmlspecialchars($article['resource_id'], ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
    <h3><?= htmlspecialchars($article['title'], ENT_QUOTES, "UTF-8") ?></h3>
    <button type="button" class="btn btn-info" onclick="location.href='/articles/<?= htmlspecialchars($article['id'], ENT_QUOTES, "UTF-8") ?>'">More</button>
    <form action="/articles/<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>/delete" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <button type="submit">Delete</button>
    </form>
    <p>-------------------------</p>
<?php endforeach; ?>
<button type="button" onclick="location.href='/articles/create'">新規作成</button>
</body>
</html>
