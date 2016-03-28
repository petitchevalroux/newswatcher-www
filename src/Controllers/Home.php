<?php

namespace NwWebsite\Controllers;

use NwWebsite\Controllers\Auth\Authenticated;
use NwWebsite\Models\Articles\Users as ArticlesUsers;
use NwWebsite\Models\Articles as Articles;
use NwWebsite\Di;

class Home extends Authenticated
{
    public function home()
    {
        $articlesIds = array_map(
                function (ArticlesUsers $o) {
            return $o->articleId;
        }, ArticlesUsers::getCollection(['user' => $this->user->id, 'status' => ArticlesUsers::STATUS_UNREAD])
        );
        $articles = Articles::getByIds($articlesIds);
        $di = Di::getInstance();
        $di->slim->render('home', ['articles' => $articles]);
    }
}
