<?php

require_once './views/articles/index.php';

// path=>function nameで連想配列を作る
const ROUTES = [
    'articles' => [
        '/' => 'articleList',
        '/create' => 'articleCreate',
        '/:id' => 'articleDetail'
    ]
];

function redirect($url) {
    header("Location: {$url}");
    exit;
}

function articleRouter($uris, $id, $function) {
    // /articles/<ここ>に何も値がない時
    if (!array_key_exists('2', $uris)) {
        $function = ROUTES[$uris[1]]['/'];
        return $function();
    }
    // /articles/<ここ>が数値またはその次に何かしらの値が入っている時
    if (is_numeric($uris[2]) && !array_key_exists('3', $uris)) {
        $function = ROUTES[$uris[1]]['/:id'];
        return $function($id);
    }
    if ($uris[2] === 'create' && !array_key_exists('3', $uris)) {
        $function = ROUTES[$uris[1]]['/create'];
        return $function();
    }
    include 'templates/404.php';
}

function router() {
    $request_uri = $_SERVER['REQUEST_URI'];
    $uris = explode('/', $request_uri);
    $id = '';
    $function = '';

    // 画像配信は特別
    if ($uris[1] === 'template' && $uris[2] === 'images' && is_numeric($uris[3])) {
        return 'http://localhost:8080' . $request_uri;
    }

    if (count($uris) >= 2) {
        // uriに一つでの数字があればbreakする。
        // TODO: これはいずれ崩壊する。そのタイミングで修正する。
        // /users/<user_id>/articles/<article_id>みたいなやつ対応。
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
    include 'templates/404.php';
}
