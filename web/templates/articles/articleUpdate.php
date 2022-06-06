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
            <li style="color:red"><?= htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form action="/articles/<?= htmlspecialchars($article[0]['id'], ENT_QUOTES, "UTF-8") ?>/update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <label class="title" for="title">タイトル</label>
        <input type="text" name="title" value="<?= htmlspecialchars($article[0]['title'], ENT_QUOTES, "UTF-8") ?>" required>
        <label class="body" for="body">本文</label>
        <textarea rows="4" id="body" name="body" required><?= htmlspecialchars($article[0]['body'], ENT_QUOTES, "UTF-8") ?></textarea>
        <?php foreach($article as $article_image) : ?>
            <div class="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>">
                <?php if ($article_image['thumbnail_image_id'] == $article_image['image_id']) : ?>
                    <img src="../../templates/images/<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
                    <input type="radio" id="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>" name="is-thumbnail" value="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>" checked>
                    <label for="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>">この画像をサムネイルにする！</label>
                <?php else: ?>
                    <img src="../../templates/images/<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
                    <input type="radio" id="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>" name="is-thumbnail" value="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>">
                    <label for="<?= htmlspecialchars($article_image['resource_id'], ENT_QUOTES, "UTF-8") ?>">この画像をサムネイルにする！</label>
                <?php endif; ?>
            </div>
        <?php endforeach;?>
        <input type="file" id="images" name="upload_image[]" multiple>
        <div id="preview"></div>
        <input type="submit" value="Update" >
    </form>
</body>
<script src="../../templates/js/preview.js"></script>
</html>
