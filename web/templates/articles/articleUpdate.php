<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>記事</title>
</head>
<body>
    <?php if($errors): ?>
    <ul class="error_list">
        <?php foreach( $errors->errors as $value ): ?>
            <li style="color:red"><?= htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form action="/articles/<?= htmlspecialchars($articleEntity->id, ENT_QUOTES, "UTF-8") ?>/update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
        <div>
            <label class="title" for="title">タイトル</label>
            <input type="text" name="title" value="<?= htmlspecialchars($articleEntity->title, ENT_QUOTES, "UTF-8") ?>" required>
        </div>
        <div>
            <label class="body" for="body">本文</label>
            <textarea rows="4" id="body" name="body" required><?= htmlspecialchars($articleEntity->body, ENT_QUOTES, "UTF-8") ?></textarea>
        </div>
        <p>登録しているタグ</p>
        <ul>
            <?php foreach($articleEntity->tags as $tag) : ?>
                <li><?= htmlspecialchars($tag, ENT_QUOTES, "UTF-8") ?></li>
            <?php endforeach;?>
        </ul>
        <div>
            <p>タグを変更する</p>
            <?php foreach( $all_tags as $tag ): ?>
                <input type="checkbox" name="tags[]" id="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>" value="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>">
                    <label for="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>"><?= htmlspecialchars($tag['name'], ENT_QUOTES, "UTF-8") ?></label>
                </input>
            <?php endforeach; ?>
        </div>
        <!-- サムネイル画像 -->
        <img src="../../templates/images/<?= htmlspecialchars($articleEntity->thumbnail_image_id, ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
        <input type="radio" id="<?= htmlspecialchars($articleEntity->thumbnail_image_id, ENT_QUOTES, "UTF-8") ?>" name="is-thumbnail" value="<?= htmlspecialchars($articleEntity->thumbnail_image_id, ENT_QUOTES, "UTF-8") ?>" checked>
        <label for="<?= htmlspecialchars($article_image, ENT_QUOTES, "UTF-8") ?>">この画像をサムネイルにする！</label>
        <!-- サムネイル以外の画像 -->
        <?php foreach($articleEntity->images as $image) : ?>
            <div class="<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>">
                <img src="../../templates/images/<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>.png" alt="" style="width:200px; height:200px">
                <input type="radio" id="<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>" name="is-thumbnail" value="<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>">
                <label for="<?= htmlspecialchars($image, ENT_QUOTES, "UTF-8") ?>">この画像をサムネイルにする！</label>
            </div>
        <?php endforeach;?>
        <input type="file" id="images" name="upload_image[]" multiple>
        <div id="preview"></div>
        <input type="submit" value="Update" >
    </form>
</body>
<script src="../../templates/js/preview.js"></script>
</html>
