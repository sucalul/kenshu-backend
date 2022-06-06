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
<form action="/articles/create" method="post" enctype="multipart/form-data" name="postForm">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
    <div>
        <label class="title" for="title">タイトル</label>
        <input id="title" type="text" name="title" required>
    </div>

    <div>
        <label class="body" for="body">本文</label>
        <textarea rows="4" id="body" name="body" required></textarea>
    </div>
    <div>
        <?php foreach( $tags as $tag ): ?>
            <input type="checkbox" name="tags[]" id="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>" value="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>">
                <label for="<?= htmlspecialchars($tag['id'], ENT_QUOTES, "UTF-8") ?>"><?= htmlspecialchars($tag['name'], ENT_QUOTES, "UTF-8") ?></label>
            </input>
        <?php endforeach; ?>
    </div>
    <div>
        <input type="file" id="images" name="upload_image[]" multiple>
        <div id="preview"></div>
    </div>
    <input type="submit" name="submit" >
</form>
<script>
    // 方針
    // 画像のプレビューと共に、サムネイル指定できるradioボタンを表示する
    // サムネイル指定したらinputにvalue=filenameを付与し、それ以外のinputからはnameを削除する

    let ids = [];
    let values = [];

    // ref: https://code-kitchen.dev/html/input-file/
    const previewFile = (file) => {
        // プレビュー画像を追加する要素を取得
        const preview = document.getElementById('preview');

        const reader = new FileReader();

        reader.onload = (e) => {
            const imageUrl = e.target.result;
            const img = document.createElement("img");
            img.src = imageUrl;
            const filename = file.name;
            // ここでvaluesにfilenameをpush
            values.push(filename);
            img.setAttribute('style', 'height:200px; width: 200px;')
            preview.appendChild(img);
            // randomなidを渡す
            random = Math.random().toString(36).slice(-8);
            ids.push(random);
            // input要素を作る
            const input = document.createElement("input");
            input.setAttribute("type", 'radio');
            input.setAttribute("id", random);
            input.setAttribute("name", "is-thumbnail");
            preview.appendChild(input);
            // label要素を作る
            const label = document.createElement('label');
            label.setAttribute('for', random);
            label.appendChild(document.createTextNode('この画像をサムネイルにする！'));
            preview.appendChild(label);
        }
        reader.readAsDataURL(file);
    }

    // <input>でファイルが選択されたときの処理
    const fileInput = document.getElementById('images');
    const handleFileSelect = () => {
        const files = fileInput.files;
        for (let i = 0; i < files.length; i++) {
            previewFile(files[i]);
        }
    }
    fileInput.addEventListener('change', handleFileSelect);

    const setValueInSelectedInput = (e) => {
        let inputs = [];
        // idに紐づくinput要素を取得
        for (let i = 0; i < ids.length; i++) {
            inputs.push(document.getElementById(ids[i]));
        }
        // e.targetにvalue=filenameを付与する、
        // それ以外はvalueを消す
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                e.target.setAttribute('value', values[i]);
            } else {
                inputs[i].removeAttribute('value');
            }
        }
    }

    window.addEventListener('change', setValueInSelectedInput);
</script>
</body>
</html>
