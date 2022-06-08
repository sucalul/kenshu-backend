<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
<h1>Signup</h1>
<?php include 'templates/session.php'; ?>
<?php if($errors): ?>
<ul class="error_list">
    <?php foreach( $errors as $value ): ?>
        <li style="color:red"><?= htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="/signup" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
    <div>
        <label for="name">名前</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label for="password">パスワード</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label for="profile_image">プロフィール画像</label>
        <input type="file" name="profile_image">
    </div>
    <input type="submit" name="submit" value="Sign Up" >
</form>
</body>
</html>
