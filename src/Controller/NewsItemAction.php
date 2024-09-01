<?php

namespace App\Controller;

use App\Repository\NewsRepository;

class NewsItemAction extends AbstractController
{
    public function __invoke($id)
    {
        $repository = new NewsRepository();
        $news = $repository->findOneById($id);

        return $this->view->render('news.html.php', ['news' => $news]);
    }
}
