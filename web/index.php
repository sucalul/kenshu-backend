
<?php

require_once './controller/articles/index.php';

// path=>function nameで連想配列を作る
const ROUTES = [
    'articles' => [
        '/' => 'article_list',
        '/:id' => 'article_detail'
    ]
];

function articleRouter($uris, $id, $function) {
    // /articles/<ここ>に何も値がない時
    if (!array_key_exists('2', $uris)) {
        $function = ROUTES[$uris[1]]['/'];
        return $function();
    }
    // /articles/<ここ>が数値またはその次に何かしらの値が入っている時
    if (!is_numeric($uris[2]) || array_key_exists('3', $uris)) {
        echo '404';
        return http_response_code(404);
    } else {
        $function = ROUTES[$uris[1]]['/:id'];
        return $function($id);
    }
}

function router() {
    $request_uri = $_SERVER['REQUEST_URI'];
    $uris = explode('/', $request_uri);
    $id = '';
    $function = '';

    // 画像配信は特別
    if ($uris[1] === 'template') {
        return 'http://localhost:8080' . $request_uri;
    }

    if (count($uris) >= 2) {
        foreach ($uris as $uri) {
            if ($id !== '') {
                break;
            }
            if (preg_match("/^[0-9]+$/", $uri)) {
                $id = $uri;
            }
        }
        // articleへのリクエストかどうか
        if ($uris[1] === 'articles') {
            return articleRouter($uris, $id, $function);
        }
    }
    echo '404だよ';
    return http_response_code(404);
}

router();
