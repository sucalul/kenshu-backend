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

<form action="/articles/create" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
    <label class="title" for="title">タイトル</label>
    <input id="title" type="text" name="title" required>
    <label class="body" for="body">本文</label>
    <textarea rows="4" id="body" name="body" required></textarea>
    <input type="file" id="images" name="upload_image[]" multiple>
    <div id="preview"></div>
    <input type="submit" name="submit" >
</form>
<script>
    // 方針
    // 画像のプレビューと共に、サムネイル指定できるradioボタンを表示する
    // サムネイル指定したらinputにname='is-thumbnail'を付与し、それ以外のinputからはnameを削除する

    let ids = [];
    // ref: https://code-kitchen.dev/html/input-file/
    function previewFile(file) {
        // プレビュー画像を追加する要素を取得
        const preview = document.getElementById('preview');

        const reader = new FileReader();

        reader.onload = (e) => {
            const imageUrl = e.target.result;
            const img = document.createElement("img");
            img.src = imageUrl;
            const filename = file.name;
            img.setAttribute('style', 'height:200px; width: 200px;')
            preview.appendChild(img);
            // randomなidを渡す
            random = Math.random().toString(36).slice(-8);
            ids.push(random);
            // input要素を作る
            const input = document.createElement("input");
            input.setAttribute("type", 'radio');
            input.setAttribute("id", random);
            input.setAttribute('value', filename);
            preview.appendChild(input)
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

    const setNameInSelectedInput = (e) => {
        // name='is-thumbnail'がついているものを消す
        let inputs = [];
        // idに紐づくinput要素を取得
        for (let i = 0; i < ids.length; i++) {
            inputs.push(document.getElementById(ids[i]));
        }
        // inputsに含まれているnameを削除
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].name == 'is-thumbnail') {
                inputs[i].removeAttribute('name');
            }
        }
        // e.targetにname='is-thumbnail'を付与する
        if (e.target.type == 'radio') {
            e.target.setAttribute('name', 'is-thumbnail');
        }
    }

    window.addEventListener('change', setNameInSelectedInput);
</script>
</body>
</html>
