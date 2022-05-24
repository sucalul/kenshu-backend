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
    function previewFile(file) {
        // プレビュー画像を追加する要素
        const preview = document.getElementById('preview');

        // FileReaderオブジェクトを作成
        const reader = new FileReader();

        // ファイルが読み込まれたときに実行する
        reader.onload = function (e) {
            const imageUrl = e.target.result;
            const img = document.createElement("img");
            img.src = imageUrl;
            console.log(file.name);
            img.setAttribute('style', 'height:200px; width: 200px;')
            preview.appendChild(img);

            const input = document.createElement("input");
            // randomなidを渡す
            // 方針
            // value, nameを付与し、送信ボタンを押したときにclickされているものだけvalue, nameを残し、その他を削除する?
            // ref
            // https://scrapbox.io/nwtgck/JavaScript:_%E3%83%AF%E3%83%B3%E3%83%A9%E3%82%A4%E3%83%B3%E3%81%A7%E3%83%A9%E3%83%B3%E3%83%80%E3%83%A0%E3%81%AA%E6%96%87%E5%AD%97%E5%88%97%E3%82%92%E5%BE%97%E3%82%8B%E6%96%B9%E6%B3%95:_Math.random()...
            random = Math.random().toString(36).slice(-8)
            input.setAttribute("type", 'radio');
            input.setAttribute("id", random);
            input.setAttribute('name', 'is-thumbnail');
            input.setAttribute('onChange', 'onRadioButtonChange(this.id)');
            // checkされたらvalueを追加する
            preview.appendChild(input)
            const label = document.createElement('label');
            label.setAttribute('for', 'is-thumbnail');
            label.appendChild(document.createTextNode('これをサムネイルにする!'));
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

    function onRadioButtonChange(id) {
        console.log(id);
        const radiobtn = document.getElementById(id);
        // target = document.getElementById("output");
        if (radiobtn.checked == true) {
            radiobtn.setAttribute('value', 'is-thumbnail');
            console.log('サムネイルです');
        } else {
            radiobtn.removeAttribute('value');
        }
    }
</script>
</body>
</html>
