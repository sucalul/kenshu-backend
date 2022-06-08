<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<h1>Signin</h1>
<?php include 'templates/session.php'; ?>
<?php if($errors): ?>
<ul class="error_list">
    <?php foreach( $errors as $value ): ?>
        <li style="color:red"><?= htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="/signin" method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
    <div>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label for="password">パスワード</label>
        <input type="password" name="password" required>
    </div>

    <input type="submit" name="submit" value="Sign In" >
</form>
</body>
</html>
