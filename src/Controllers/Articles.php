<?php

namespace NwWebsite\Controllers;

use NwWebsite\Controllers\Auth\Authenticated;
use NwWebsite\Models\Articles\Users as ArticlesUsersModel;
use NwWebsite\Di;

class Articles extends Authenticated
{
    const DEFAULT_CONTENT_TYPE = 'application/json';

    public function get()
    {
        $di = Di::getInstance();
        $status = (int) $di->slim->request->get('status');
        $userArticles = ArticlesUsersModel::getCollection([
                    'user' => $this->user->id,
                    'status' => $status,
        ]);
        $articles = [];
        foreach ($userArticles as $userArticle) {
            $article = $userArticle->article;
            unset($article['user']);
            unset($article['urlHash']);
            $article['id'] = $userArticle->id;
            $articles[] = $article;
        }
        $this->response($articles);
    }

    public function update($articleId)
    {
        $di = Di::getInstance();
        $body = $di->slim->request->getBody();
        $status = isset($body['status']) ? (int) $body['status'] : false;
        if ($status === ArticlesUsersModel::STATUS_UNREAD
            || $status === ArticlesUsersModel::STATUS_READ
            || $status === ArticlesUsersModel::STATUS_DELETED) {
            $article = ArticlesUsersModel::get($articleId);
            $article->status = $status;
            $article->save();
        }
    }

    private function response($body)
    {
        $di = Di::getInstance();
        $di->slim->response->headers->set('Content-Type', static::DEFAULT_CONTENT_TYPE);
        $di->slim->response->setBody(json_encode($body));
    }
}
