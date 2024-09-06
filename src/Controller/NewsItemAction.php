<?php

namespace App\Controller;

use App\Repository\Exception\ItemNotFoundException;
use App\Repository\NewsRepository;

class NewsItemAction extends AbstractController
{
    /**
     * @throws ItemNotFoundException
     */
    public function __invoke($id): \App\Http\Response
    {
        $repository = new NewsRepository();
        $news = $repository->findOneById($id);

        return $this->view->render('news.html.php', ['news' => $news]);
    }
}
