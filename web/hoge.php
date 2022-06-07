<?php

require_once './views/Controller.php';

class Router {
    // path=>function nameで連想配列を作る
    const ROUTES = [
        'articles' => [
            '/' => 'articleList',
            '/create' => [
                'get' => 'getArticleCreate',
                'post' => 'postArticleCreate'
            ],
            '/:id' => [
                '' => 'articleDetail',
                '/update' => [
                    'get' => 'getArticleUpdate',
                    'post' => 'postArticleUpdate'
                ],
                '/delete' => 'articleDelete'
            ]
        ]
    ];

    private function articleRouter($uris, $id, $function) {
        $controller = new Controller();
        // /articles/<ここ>に何も値がない時
        if (!array_key_exists('2', $uris)) {
            $function = self::ROUTES[$uris[1]]['/'];
            return $controller->$function();
        }
        // create
        if ($uris[2] === 'create' && !array_key_exists('3', $uris)) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $function = self::ROUTES[$uris[1]]['/create']['get'];
                return $controller->$function();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $function = self::ROUTES[$uris[1]]['/create']['post'];
                return $controller->$function();
            }
        }
        // /articles/<ここ>が数値またはその次に何かしらの値が入っている時
        if (is_numeric($uris[2])) {
            if (!array_key_exists('3', $uris)) {
                $function = self::ROUTES[$uris[1]]['/:id'][''];
                return $controller->$function($id);
            } elseif ($uris[3] === 'update' && !array_key_exists('4', $uris)) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $function = self::ROUTES[$uris[1]]['/:id']['/update']['get'];
                    return $controller->$function($id);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $function = self::ROUTES[$uris[1]]['/:id']['/update']['post'];
                    return $controller->$function($id);
                }
                $function = self::ROUTES[$uris[1]]['/:id']['/update'];
                return $function($id);
            } elseif ($uris[3] === 'delete' && !array_key_exists('4', $uris) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $function = self::ROUTES[$uris[1]]['/:id']['/delete'];
                return $controller->$function($id);
            }
        }
        http_response_code(404);
        include 'templates/404.php';
    }

    public function router() {
        $request_uri = $_SERVER['REQUEST_URI'];
        $uris = explode('/', $request_uri);
        $id = '';
        $function = '';

        // 画像配信は特別
        if ($uris[1] === 'templates' && $uris[2] === 'images' && is_numeric($uris[3])) {
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
                    $id = (int) $uri;
                }
            }
            // articleへのリクエストかどうか
            if ($uris[1] === 'articles') {
                return $this->articleRouter($uris, $id, $function);
            }
        }
        http_response_code(404);
        include 'templates/404.php';
    }
}
