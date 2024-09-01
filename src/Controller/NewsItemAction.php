<?php

namespace App\Controller;

use App\Repository\NewsRepository;

class NewsItemAction
{
    public function __invoke($id)
    {
        $repository = new NewsRepository();
        $news = $repository->findOneById($id);

        var_dump($news);
    }
}
