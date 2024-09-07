<?php

namespace App\Controller;

use App\Repository\Exception\ItemNotFoundException;
use App\Repository\NewsRepository;
use App\Http\Response;

class NewsItemAction extends AbstractController
{
    /**
     * @throws ItemNotFoundException
     */
    public function __invoke(string $id): Response
    {
        $repository = new NewsRepository();
        $news = $repository->findById($id);

        return $this->view->render('news.html.php', ['news' => $news]);
    }
}
