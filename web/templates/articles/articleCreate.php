<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<?php if($errors): ?>
<ul class="error_list">
    <?php foreach( $errors as $value ): ?>
        <li style="color:red"><?= $value; ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<form action="/articles/create" method="post">
    <label class="title" for="title">タイトル</label>
    <input id="title" type="text" name="title" required>
    <label class="body" for="body">本文</label>
    <textarea rows="4" id="body" name="body" required></textarea>
    <input type="submit" name="submit" >
</form>
</body>
</html>
