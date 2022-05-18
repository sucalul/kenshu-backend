
<?php

require_once './controller/articles/index.php';

// path=>function nameで連想配列を作る
const ROUTES = [
    'articles' => [
        '/' => 'article_list',
        '/:id' => 'article_detail'
    ]
];

function uri_check() {
    $request_uri = $_SERVER['REQUEST_URI'];
    // echo $request_uri;
    $uris = explode('/', $request_uri);
    $id = '';
    // echo $uris[1];
    // echo '-------';
    // echo ROUTES[$uris[1]][0];
    // echo ROUTES['articles']['/'];
    // echo '-------';
    // echo $uris[2];
    foreach ($uris as $uri) {
        if (preg_match("/^[0-9]+$/", $uri)) {
            $id = $uri;
            echo 'これは整数です！';
        }
    }
    $function = '';
    if ($id == '') {
        // echo $uris[0];
        // echo ROUTES[$uris[1]]['/'];
        $function = ROUTES[$uris[1]]['/'];
        return $function();
    } else {
        $function = ROUTES[$uris[1]]['/:id'];
        return $function($id);
    }
}

uri_check();

?>
