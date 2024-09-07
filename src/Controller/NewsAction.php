<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Http\Response;

class NewsAction extends AbstractController
{
    public function __invoke(): Response
    {
        $repository = new NewsRepository();
        $newsCollection = $repository->findAll();

        return $this->view->render('news-list.html.php', ['list' => $newsCollection]);
    }
}
