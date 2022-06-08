<?php

require_once './views/ArticleController.php';
require_once './views/AuthController.php';

class Router
{
    private function articleRouter($request_uri, $article_id)
    {
        $controller = new ArticleController();
        // /articles/<ここ>に何も値がない時
        if ($request_uri === '/articles') {
            return $controller->articleList();
        }
        // create
        if ($request_uri === '/articles/create') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                return $controller->getArticleCreate();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return $controller->postArticleCreate();
            }
        }
        // detail
        if ($request_uri === "/articles/${article_id}") {
            return $controller->articleDetail($article_id);
        }
        // update
        if ($request_uri === "/articles/${article_id}/update") {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                return $controller->getArticleUpdate($article_id);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return $controller->postArticleUpdate($article_id);
            }
        }
        // delete
        if ($request_uri === "/articles/${article_id}/delete" && $_SERVER['REQUEST_METHOD'] === 'POST') {
            return $controller->articleDelete($article_id);
        }
        http_response_code(404);
        include 'templates/404.php';
    }

    private function authRouter($request_uri)
    {
        $controller = new AuthController();
        if ($request_uri === '/signup') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                return $controller->getSignup();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return $controller->postSignup();
            }
        }
    }

    public function router()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $uris = explode('/', $request_uri);
        $article_id = '';
        // 画像配信は特別
        if ($uris[1] === 'templates' && $uris[2] === 'images' && is_numeric($uris[3])) {
            return 'http://localhost:8080' . $request_uri;
        }
        if (count($uris) >= 2) {
            // uriに一つでの数字があればbreakする。
            // TODO: これはいずれ崩壊する。そのタイミングで修正する。
            // /users/<user_id>/articles/<article_id>みたいなやつ対応。
            foreach ($uris as $uri) {
                if ($article_id !== '') {
                    break;
                }
                if (preg_match("/^[0-9]+$/", $uri)) {
                    $article_id = (int)$uri;
                }
            }
            // articleへのリクエストかどうか
            if ($uris[1] === 'articles') {
                return $this->articleRouter($request_uri, $article_id);
            } elseif ($uris[1] === 'signup') {
                return $this->authRouter($request_uri);
            }
        }
        http_response_code(404);
        include 'templates/404.php';
    }
}
