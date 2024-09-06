<?php

namespace App\Controller;

use App\Repository\NewsRepository;

class NewsCollectionAction extends AbstractController
{
    public function __invoke(): \App\Http\Response
    {
        $repository = new NewsRepository();
        $newsCollection = $repository->findAll();

        return $this->view->render('news-list.html.php', ['list' => $newsCollection]);
    }
}
