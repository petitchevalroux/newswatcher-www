<?php

namespace NwWebsite\Controllers;

use NwWebsite\Controllers\Auth\Authenticated;
use NwWebsite\Models\Articles\Users as ArticlesUsersModel;
use NwWebsite\Models\Articles as ArticlesModel;
use NwWebsite\Di;

class Articles extends Authenticated
{
    const DEFAULT_CONTENT_TYPE = 'application/json';
    public function get()
    {
        $articlesIds = array_map(
                function (ArticlesUsersModel $o) {
            return $o->articleId;
        }, ArticlesUsersModel::getCollection(['user' => $this->user->id, 'status' => ArticlesUsersModel::STATUS_UNREAD])
        );
        $articles = ArticlesModel::getByIds($articlesIds);
        $this->response($articles);
    }

    private function response($body)
    {
        $di = Di::getInstance();
        $di->slim->response->headers->set('Content-Type', static::DEFAULT_CONTENT_TYPE);
        $di->slim->response->setBody(json_encode($body));
    }
}
